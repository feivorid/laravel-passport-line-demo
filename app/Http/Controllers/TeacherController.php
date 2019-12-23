<?php

namespace App\Http\Controllers;

use App\Models\StudentFollowTeacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{

    public function index()
    {
        $user = auth('teacher')->user();

        if (!$user) {
            return response()->json([
                'code'    => 401,
                'message' => '请先登录',
            ]);
        }

        $students = $user
            ->students()
            ->with('students')
            ->where('status', StudentFollowTeacher::STATUS_ON)
            ->get();

        return response()->json(compact('user', 'students'));
    }
}
