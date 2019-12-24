<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentFollowTeacher;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{

    /**
     * 学生登录后首页
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = auth('student')->user();
        if (!$user) {
            return response()->json(['code' => '401', 'message' => '未登录']);
        }

        $teachers = Teacher::query()
            ->with(['follows' => function ($query) use ($user) {
                $query->where('student_id', $user->id);
            }])
            ->where('enabled', true)
            ->get();

        $teachers->each(function ($item) {
            if ($item->follows) {
                $teacher = $item->follows->first();
                $item->followed = $teacher && $teacher->status == StudentFollowTeacher::STATUS_ON ? true : false;
            } else {
                $item->followed = false;
            }
        });

        return response()->json(compact('user', 'teachers'));
    }

    /**
     * 关注/取消关注  老师
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'teacher_id' => 'required',
            'status'     => 'required',
        ], [
            'teacher_id.required' => 'teacher_id参数缺失',
            'status.required'     => 'status参数缺失',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        $studentId = auth('student')->user()->id;
        $teacherId = $request->get('teacher_id');
        $status = $request->get('status');

        $follow = StudentFollowTeacher::query()
            ->where('student_id', $studentId)
            ->where('teacher_id', $teacherId)
            ->first();

        if (!$follow) {
            StudentFollowTeacher::query()->create([
                'student_id' => $studentId,
                'teacher_id' => $teacherId,
                'status'     => $status,
            ]);

            return response()->json([
                'message' => '操作成功',
            ]);
        }

        if ($follow && $follow->status == $status) {
            $str = $status == StudentFollowTeacher::STATUS_ON ? '关注' : '取消关注';
            return response()->json([
                'message' => '已' . $str . '，不能重复操作',
            ], 400);
        }

        $follow->status = !$follow->status;
        $follow->save();

        return response()->json([
            'message' => '操作成功',
        ]);
    }
}
