<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApiStoreBankRequest;
use App\Models\Bank;

class BankController extends Controller
{
    public function index(Request $request) {
        $result = array(
            'status_code' => 200,
            'params' => array('banks' => Bank::all()),
        );

        return response()->json($result);
    }

    public function show(Request $request, $user_id) {
        if(empty($user_id)) {
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        if(auth()->guard('api')->check()){
            $banks = Bank::findByUserIdWithJapanAndOtherBank($user_id);
        } elseif (auth()->guard('api_manager')->check()) {
            $banks = Bank::findByUserIdWithJapanAndOtherBankManager($user_id);
        }

        $result = array();

        if(empty($bank)) {
            $result = array(
                'status_code' => 400,
            );
        } else {
            $result = array(
                'status_code' => 200,
                'params' => array('bank' => $bank),
            );
        }

        return response()->json($result);
    }

    public function store(ApiStoreBankRequest $request) {
        $request_data = array(
            'user_id' => $request->post('user_id'),
            'type' => $request->post('type'),
            'name' => $request->post('name'),
            'number' => $request->post('number'),
        );

        $result = array();

        try {
            $bank = new Bank($request_data);
            $bank->save();

            $result = array(
                'status_code' => 200,
            );
        } catch (\Exception $e) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['銀行情報の登録に失敗しました。'],
            );
        }

        return response()->json($result);
    }

    public function delete(Request $request, $bank_id) {
        if(empty($bank_id)) {
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        $bank = Bank::findByID($bank_id);
        $result = array();

        if(empty($bank)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['銀行情報の削除に失敗しました。'],
            );
        } else {
            $result = array(
                'status_code' => 200,
            );

            $bank->delete();
        }

        return response()->json($result);
    }
}
