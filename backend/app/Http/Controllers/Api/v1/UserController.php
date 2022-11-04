<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApiStoreActivationRequest;
use App\Http\Requests\ApiStoreUserRequest;
use App\Http\Requests\ApiLoginUserRequest;
use App\Http\Requests\ApiUpdatePasswordRequest;
use App\Models\User;
use App\Models\EmailActivation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function storeTemporary(ApiStoreActivationRequest $request) {
        $result = array();
        $email = $request->post('email');

        $email_activation = EmailActivation::findByEmail($email);
        $registered_user = User::findByEmail($email);

        if(!empty($email_activation)) {
            $result = array(
                'status_code' => 401,
                'error_messages' => ["仮登録済みです。受信ボックスをご確認ください。"],
            );
        } elseif(!empty($registered_user)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ["入力したメールアドレスは既に登録済みです。同じメールアドレスは使用できません。"]
            );
        } else {
            $new_activation = EmailActivation::build($email);
            $new_activation->save();

            $result = array(
                'status_code' => 200,
                'success_message' => '仮登録に成功しました。1時間以内に本登録を完了させてください。',
            );
        }

        return response()->json($result);
    }

    public function storeMain(ApiStoreUserRequest $request) {
        $result = array();
        $user_data = array(
            'last_name' => $request->post('last_name'),
            'first_name' => $request->post('first_name'),
            'last_name_kana' => $request->post('last_name_kana'),
            'first_name_kana' => $request->post('first_name_kana'),
            'email' => $request->post('email'),
            'password' => Hash::make($request->post('password')),
            'phone_number' => $request->post('phone_number'),
            'postcode' => $request->post('postcode'),
            'city' => $request->post('city'),
            'block' => $request->post('block'),
        );

        $email_activation = EmailActivation::findByEmail($user_data['email']);

        if(empty($email_activation)) {
            $result = array(
                'status_code' => 401,
                'error_messages' => ["有効期限が切れています。1時間以内に本登録の完了までお願い致します。"]
            );
        } elseif(!$email_activation->isExpiration()) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ["有効期限が切れています。1時間以内に本登録の完了までお願い致します。"]
            );
        } else {
            $user = new User($user_data);
            $user->save();

            $result = array(
                'status_code' => 200,
                'success_messages' => ["本登録に成功しました。"]
            );
        }

        return response()->json($result);
    }

    public function requestPassword(ApiStoreActivationRequest $request) {
        $email = $request->post('email');
        $result = array();
        $registered_user = User::findByEmail($email);

        if(empty($registered_user)) {
            $result = array(
                'status_code' => 400,
                'success_messages' => ['ユーザーの登録がありません、新規登録を行ってください。'],
                'params' => array('email' => $email),
            );
        } else {
            EmailActivation::deleteByEmail($email);

            $new_activation = EmailActivation::build($email, 1);
            $new_activation->save();

            $result = array(
                'status_code' => 200,
                'success_messages' => ['再発行用パスワードURLを送信しました。'],
                'params' => array('email' => $email),
            );
        }

        return response()->json($result);
    }

    public function login(ApiLoginUserRequest $request) {
        $email = $request->post('email');
        $password = $request->post('password');
        
        $result = array();

        if (auth()->attempt(['email' => $email, 'password' => $password])) {
            $new_token = Str::random(60);
            
            $user = auth()->user();
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

    public function logout(Request $request) {
        $result = array();

        if (auth()->user()) {
            $user = auth()->user();
            $user->api_token = null;
            $user->save();
            
            $result = array(
                        'status_code' => 200,
                        'success_messages' => 'ログアウトしました。'
                    );
        } else {
            $result = array(
                'status_code' => 400,
                'error_message' => 'ログアウトに失敗しました',
            );
        }

        return response()->json($result);
    }

    public function updateProfile(ApiStoreUserRequest $request) {
        $result = array();
        $user_data = array(
            'last_name' => $request->input('last_name'),
            'first_name' => $request->input('first_name'),
            'last_name_kana' => $request->input('last_name_kana'),
            'first_name_kana' => $request->input('first_name_kana'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone_number' => $request->input('phone_number'),
            'postcode' => $request->input('postcode'),
            'city' => $request->input('city'),
            'block' => $request->input('block'),
        );

        $user = auth()->user();

        if(empty($user)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ["プロフィールの更新に失敗しました。"]
            );
        } else {
            $user->last_name = $user_data['last_name'];
            $user->first_name = $user_data['first_name'];
            $user->last_name_kana = $user_data['last_name_kana'];
            $user->first_name_kana = $user_data['first_name_kana'];
            $user->email = $user_data['email'];
            $user->password = $user_data['password'];
            $user->phone_number = $user_data['phone_number'];
            $user->postcode = $user_data['postcode'];
            $user->city = $user_data['city'];
            $user->block = $user_data['block'];

            $user->save();

            $result = array(
                'status_code' => 200,
                'success_messages' => ["プロフィールの更新に成功しました。"]
            );
        }

        return response()->json($result);
    }

    public function updatePassword(ApiUpdatePasswordRequest $request) {
        $result = array();
        $password = $request->input('password');
        $user = auth()->user();

        if(empty($user)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ["パスワード更新に失敗しました。"]
            );
        } else {
            $user->password = Hash::make($password);
            $user->save();

            $result = array(
                'status_code' => 200,
                'success_messages' => ["パスワード更新に成功しました。"]
            );
        }

        return response()->json($result);
    }

    public function deleteWithdrawal(Request $request, $request_user_id) {
        $result = array();
        $user = auth()->user();

        if($request_user_id != $user->id) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ["ユーザーの削除に失敗しました。"]
            );
        } else {
            $user->delete();

            $result = array(
                'status_code' => 200,
                'success_messages' => ["ユーザーの削除に成功しました。"]
            );
        }

        return response()->json($result);
    }

    public function index(Request $request) {
        $result = array(
            'status_code' => 200,
            'params' => array('staffs' => User::all()),
        );

        if(empty(User::all()))
        $result = array(
            'status_code' => 400,
            'error_messages' => ['ユーザー一覧の取得に失敗しました。']
        );

        return response()->json($result);
    }

    public function show(Request $request, $user_id) {
        $user = User::findByID($user_id);
        $result = array();

        if(empty($staff)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['ユーザー詳細の取得に失敗しました。'],
            );
        } else {
            $result = array(
                'status_code' => 200,
                'params' => array('user' => $user),
            );
        }

        return response()->json($result);
    }

    public function update(ApiUpdateUserRequest $request) {
        $result = array();

        $user_id = $request->input('user_id');
        $status = $request->input('status');        
        $memo = $request->input('memo');
        $user = User::findById($user_id);

        if(empty($user)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['ユーザー情報の更新に失敗しました。']
            );
        } else {
            $user->status = $status;
            $user->memo = $memo;
            $user->save();

            $result = array(
                'status_code' => 200,
                'success_messages' => ['ユーザー情報の更新に成功しました。'],
            );
        }

        return response()->json($result);
    }

    public function delete(Request $request, $user_id) {
        if(empty($user_id)) {
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        $user = User::findByID($user_id);
        $result = array();

        if(empty($user)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['ユーザーの削除に失敗しました。']
            );
        } else {
            $result = array(
                'status_code' => 200,
                'success_messages' => ['ユーザーの削除に成功しました。'],
            );

            $user->delete();
        }

        return response()->json($result);
    }
}
