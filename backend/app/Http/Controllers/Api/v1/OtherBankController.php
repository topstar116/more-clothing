<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApiStoreOtherBankRequest;
use App\Models\OtherBank;

class OtherBankController extends Controller
{
    public function store(ApiStoreOtherBankRequest $request) {
        $request_data = array(
            'bank_id' => $request->post('bank_id'),
            'bank_name' => $request->post('bank_name'),
            'shop_name' => $request->post('shop_name'),
            'shop_number' => $request->post('shop_number'),
        );

        $result = array();

        try {
            $other_bank = new OtherBank($request_data);
            $other_bank->save();

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

        $other_bank = OtherBank::findByID($bank_id);
        $result = array();

        if(empty($other_bank)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['銀行情報の削除に失敗しました。'],
            );
        } else {
            $result = array(
                'status_code' => 200,
            );

            $other_bank->delete();
        }

        return response()->json($result);
    }
}
