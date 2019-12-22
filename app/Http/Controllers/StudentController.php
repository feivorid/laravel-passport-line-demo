<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentFollowTeacher;
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
        $student = auth('student_api')->user();
        if (!$student) {
            return response()->json('未登录');
        }

        $follows = $student
            ->teachers()
            ->with('teacher')
            ->where('status', StudentFollowTeacher::STATUS_ON)
            ->get();

        return response()->json(compact('student', 'follows'));
    }

    /**
     * 关注/取消关注  老师
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required',
            'teacher_id' => 'required',
            'action'     => 'required',
        ], [
            'student_id.required' => 'student_id参数缺失',
            'teacher_id.required' => 'teacher_id参数缺失',
            'action.required'     => 'action参数缺失',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first());
        }

        $studentId = $request->get('student_id');
        $teacherId = $request->get('teacher_id');
        $action = $request->get('action');

        if ($action == StudentFollowTeacher::STATUS_ON) {
            $follow = StudentFollowTeacher::query()
                ->where('student_id', $studentId)
                ->where('teacher_id', $teacherId)
                ->first();

            if (!$follow) {
                StudentFollowTeacher::query()->create([
                    'student_id' => $studentId,
                    'teacher_id' => $teacherId,
                    'status'     => $action,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => '操作成功',
                ]);
            }

            if ($follow->status == $action) {
                $str = $action == StudentFollowTeacher::STATUS_ON ? '关注' : '取消关注';
                return response()->json([
                    'success' => false,
                    'message' => '已' . $str . '，不能重复操作',
                ]);
            }

            $follow->status = !$follow->status;
            $follow->save();

            return response()->json([
                'success' => true,
                'message' => '操作成功',
            ]);
        }
    }
}
