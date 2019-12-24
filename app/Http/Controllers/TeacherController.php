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

        $follows = $user->follows()
            ->with(['student' => function ($query) {
                $query->select('id', 'name', 'email');
            }])
            ->where('status', StudentFollowTeacher::STATUS_ON)
            ->select('id', 'status', 'student_id')
            ->get();

        return response()->json(compact('user', 'follows'));
    }
}
