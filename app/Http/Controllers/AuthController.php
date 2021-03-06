<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\Student;
use App\Models\Teacher;
use App\Traits\PassportToken;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    use PassportToken;

    /**
     * 登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required',
            'password' => 'required',
            'type'     => 'required', //student teacher
        ], [
            'email.required'    => '请输入邮箱',
            'password.required' => '请输入密码',
            'type.required'     => '请选择类型',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code'    => 400,
                'message' => $validator->errors()->first(),
            ]);
        }

        $username = $request->get('email');
        $type = $request->get('type', 'student');

        if ($type == 'student') {
            $user = Student::query()->where('email', $username)->first();
        } else {
            $user = Teacher::query()->where('email', $username)->first();
        }

        if (!$user) {
            return response()->json([
                'code'    => 401,
                'message' => '账号或密码错误',
            ]);
        }

        if ($user && $user->enabled == 0) {
            return response()->json([
                'code'    => 401,
                'message' => '您的账号已被禁用,无法登录',
            ]);
        }

        $client = new Client();

        $request = $client->request('POST', request()->root() . '/oauth/token', [
            'form_params' => config('passport') + $request->only(['email', 'password']) + ['guard' => $type],
        ]);
        //        try {
        //            $request = $client->request('POST', config('app.url') . '/oauth/token', [
        //                'form_params' => config('passport') + $request->only(['email', 'password']) + ['guard' => $type],
        //            ]);
        //        } catch (\RuntimeException $e) {
        //            return response()->json([
        //                'message' => '账号或密码错误',
        //            ], 401);
        //        }

        if ($request->getStatusCode() == '401') {
            return response()->json([
                'code'    => 401,
                'message' => '账号或密码错误',
            ]);
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
            'code'    => 200,
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
        //        dd(DB::table('oauth_clients')->get()->toArray());
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
                'code'    => 422,
                'message' => $validator->errors()->first(),
            ]);
        }

        if (!in_array($request->get('type'), ['student', 'teacher'])) {
            return response()->json([
                'code'    => 400,
                'message' => '注册类型有误',
            ]);
        }

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        unset($data['type']);

        if ($request->get('type') == 'student') {
            if (Student::query()->where('email', $request->get('email'))->exists()) {
                return response()->json([
                    'code'    => 400,
                    'message' => '邮箱已被注册，请换一个邮箱',
                ]);
            }
            Student::query()->create($data);
        } else {
            if (Teacher::query()->where('email', $request->get('email'))->exists()) {
                return response()->json([
                    'code'    => 400,
                    'message' => '邮箱已被注册，请换一个邮箱',
                ]);
            }
            Teacher::query()->create($data);
        }

        return response()->json([
            'code'    => 200,
            'message' => '注册成功',
        ]);
    }

    public function line()
    {
        return Socialite::with('line')->redirect();
    }

    public function lineCallback()
    {
        try {
            $user = Socialite::driver('line')->user();

            $line = Line::query()->where('line_id', $user->getId())->first();

            if (!$line) {
                $line = Line::query()->create([
                    'line_id' => $user->getId(),
                    'name'    => $user->getName(),
                    'email'   => $user->getEmail(),
                    'avatar'  => $user->getAvatar(),
                ]);
                $type = 'new';
            } else {
                $teacher = Teacher::query()->where('line_id', $user->getId())->where('enabled', true)->first();
                $students = Student::query()->where('line_id', $user->getId())->where('enabled', true)->get();

                if ($teacher || $students->count() > 0) {
                    $type = 'old';
                } else {
                    $type = 'new';
                }
            }

            info(111111);
            info($type);
            info($line);
            return view('auth.line', [
                'type'     => $type,
                'line'     => $line ?? null,
                'teacher'  => $teacher ?? null,
                'students' => $students ?? null,
            ]);
        } catch (\Exception $e) {
            info($e);
            return redirect('/');
        }
    }

    public function lineOld(Request $request)
    {
        $id = $request->get('id');
        $type = $request->get('type');

        if ($type === 'teacher') {
            $user = Teacher::query()->find($id);
        } else {
            $user = Student::query()->find($id);
        }

        return $this->getBearerTokenByUser($user, 2, false);
    }

    public function lineNew(Request $request)
    {
        $type = $request->get('type');
        $lineId = $request->get('line_id');

        $line = Line::query()->where('line_id', $lineId)->first();

        if (!$line) {
            return response()->json([
                'message' => '未获取到line用户信息',
            ], 400);
        }

        if ($type == 'teacher') {
            $data = [
                'name'     => $line->name,
                'password' => bcrypt($line->line_id),
                'line_id'  => $line->line_id,
            ];
            if (!Teacher::query()->where('email', $line->email)->where('enabled', true)->exit()) {
                $data['email'] = $line->email;
            }
            $user = Teacher::query()->create($data);
        } else {
            $data = [
                'name'     => $line->name,
                'password' => bcrypt($line->line_id),
                'line_id'  => $line->line_id,
            ];
            if (!Student::query()->where('email', $line->email)->where('enabled', true)->exists()) {
                $data['email'] = $line->email;
            }
            $user = Student::query()->create($data);
        }

        return $this->getBearerTokenByUser($user, 2, false);
    }
}
