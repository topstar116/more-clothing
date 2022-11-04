<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApiLoginUserRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        // $this->middleware(['auth:api', 'auth:manager'])->except(['login']);
        // $this->middleware('auth.manager')->except(['login']);
    }

    public function login(ApiLoginUserRequest $request) {
        $email = $request->post('email');
        $password = $request->post('password');
        
        $result = array();

        if (auth()->guard('manager')->attempt(['email' => $email, 'password' => $password])) {
            $new_token = Str::random(60);
            
            $user = auth()->guard('manager')->user();
            $user->api_token = $new_token;
            $user->save();

            $result = array(
                        'status_code' => 200,
                        'token' => $new_token
                    );
        } else {
            $result = array(
                        'status_code' => 400,
                        'error_message' => ['ログインに失敗しました。メールアドレスとパスワードをご確認ください。'],
                    );
        }

        return response()->json($result);
    }
}
