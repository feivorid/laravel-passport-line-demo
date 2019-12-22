<?php

namespace App\Http\Controllers;

use App\Models\StudentFollowTeacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{

    public function index()
    {
        $teacher = auth('teacher_api')->user();

        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => '请先登录',
            ]);
        }

        $students = $teacher
            ->students()
            ->with('students')
            ->where('status', StudentFollowTeacher::STATUS_ON)
            ->get();

        return response()->json(compact('teacher', 'students'));
    }
}
