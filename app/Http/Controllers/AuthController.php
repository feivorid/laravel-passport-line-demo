<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class AuthController extends Controller
{

    /**
     * 登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'type'     => 'required', //student teacher
        ], [
            'username.required' => '请输入邮箱',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $username = $request->get('username');
        $type = $request->get('type', 'student');

        if ($type == 'student') {
            $user = Student::query()->where('email', $username)->first();
        } else {
            $user = Teacher::query()->where('email', $username)->first();
        }

        if (!$user) {
            return response()->json([
                'message' => '账号或密码错误',
            ], '401');
        }

        if ($user && $user->enabled == 0) {
            return response()->json([
                'message' => '您的账号已被禁用,无法登录',
            ], '401');
        }

        $client = new Client();

        try {
            $request = $client->request('POST', config('app.url') . '/oauth/token', [
                'form_params' => config('passport') + $request->only(array_keys($request->rules())) + ['guard' => $type],
            ]);
        } catch (\RuntimeException $e) {
            return response()->json([
                'message' => '账号或密码错误',
            ], 401);
        }

        if ($request->getStatusCode() == '401') {
            return response()->json([
                'message' => '账号或密码错误',
            ], 401);
        }

        return response()->json($request->getBody()->getContents());
    }

    /**
     * 登出
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $type = $request->get('type', 'student');

        if (\auth($type)->check()) {
            \auth($type)->user()->token()->delete();
        }

        return response()->json([
            'message' => '登出成功',
        ]);
    }

    /**
     * 注册
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required',
            'password' => 'required',
            'type'     => 'required',
        ], [
            'email.required'    => '请输入邮箱',
            'password.required' => '请输入密码',
            'type.required'     => '请选择类型',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        if (!in_array($request->get('type'), ['student', 'teacher'])) {
            return response()->json([
                'message' => '注册类型有误',
            ], 400);
        }

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        unset($data['type']);

        if ($type = 'student') {
            Student::query()->create($data);
        } else {
            Teacher::query()->create($data);
        }

        return response()->json([
            'message' => '注册成功',
        ]);
    }
}