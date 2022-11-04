<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApiStoreJapanBankRequest;
use App\Models\JapanBank;

class JapanBankController extends Controller
{
    public function store(ApiStoreOtherBankRequest $request) {
        $request_data = array(
            'bank_id' => $request->post('bank_id'),
            'mark' => $request->post('mark'),
        );

        $result = array();

        try {
            $japan_bank = new JapanBank($request_data);
            $japan_bank->save();

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

        $japan_bank = JapanBank::findByID($bank_id);
        $result = array();

        if(empty($japan_bank)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['銀行情報の削除に失敗しました。'],
            );
        } else {
            $result = array(
                'status_code' => 200,
            );

            $japan_bank->delete();
        }

        return response()->json($result);
    }
}
