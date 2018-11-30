<?php

namespace App\Http\Controllers;

use App\User;
use RuntimeException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorizationController extends Controller
{
    public function login(Request $request)
    {
        if ($this->validateLoginData($request))
        {
            return response()->json([
                'status' => 'error',
                'code' => 501,
                'message' => 'Неверный формат данных'
            ], 200);
        }
        try
        {
            $user = User::where('login', $request->input('login'))->firstOrFail();
        }
        catch (ModelNotFoundException $e)
        {
            return response()->json([
                'status' => 'error',
                'code' => 400,
                'message' => 'Неверный логин или пароль'
            ], 200);
        }
        if (Hash::check($request->input('password'),$user->password))
        {
            $sid = $this->registerSession($user);
            return response()->json([
                'status' => 'success',
                'code' => 200,
                'sid' => $sid
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Неверный логин или пароль',
            ], 200);
        }
    }

    public function checkSessionID (Request $request)
    {
        return response()->json([
            'status' => 'success',
            'code' => 200
        ], 200);
    }

    private function validateLoginData($request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|min:3|max:64',
            'password' => 'required|min:6|max:64',
        ]);
        return $validator->fails();
    }

    private function registerSession($user)
    {
        $sid = self::generateSessionID();
        $user->session_id = $sid;
        $user->save();
        return $sid;
    }

    private static function generateSessionID()
    {
        if ( ! function_exists('openssl_random_pseudo_bytes'))
        {
            throw new RuntimeException('OpenSSL extension is required.');
        }

        $bytes = openssl_random_pseudo_bytes(64 * 2);

        if ($bytes === false)
        {
            throw new RuntimeException('Unable to generate random string.');
        }

        return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, 64);
    }

}
