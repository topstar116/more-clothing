<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApiStoreWithdrawalRequest;
use App\Models\WithdrawalPoint;
use Carbon\Carbon;

class WithdrawalPointController extends Controller
{
    public function store(ApiStoreWithdrawalRequest $request) {
        $data = array(
            'wallet_id' => $request->post('wallet_id'),
            'bank_id' => $request->post('bank_id'),
            'staff_id' => $request->post('staff_id'),
            'point' => $request->post('point'),
            'fee' => $request->post('fee'),
            'memo' => $request->post('memo'),
        );
        $result = array();

        try {
            $shop = new WithdrawalPoint($data);
            $shop->save();

            $result = array(
                'status_code' => 200,
                'error_messages' => ['出金登録が完了しました。'],
            );
        } catch (\Exception $e) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['出金登録に失敗しました。'],
            );
        }

        return response()->json($result);
    }

    public function updateComplete(Request $request,  $withdrawal_point_id){
        $memo = $request->input('memo');
        
        if(empty($withdrawal_point_id)) {
            return response()->json(array(
                'status_code' => 422,
                'error_message' => ['withdrawal_point_id'],
            ));
        } elseif(empty($memo)) {
            return response()->json(array(
                'status_code' => 422,
                'error_message' => ['memo'],
            ));
        }

        $withdrawal_point = WithdrawalPoint::findByID($withdrawal_point_id);

        if(empty($withdrawal_point_id)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['出金完了に失敗しました。'],
            );
        } else {
            $result = array(
                'status_code' => 200,
                'error_messages' => ['出金が完了しました。'],
            );

            $withdrawal_point-> withdrawal_at = Carbon::now();
            $withdrawal_point-> memo = $memo;
            $withdrawal_point-> save();
        }

        return response()->json($result);
    }

    public function delete(Request $request, $wallet_id) {
        if(empty($wallet_id)) {
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        $withdrawal_point = WithdrawalPoint::findByID($wallet_id);
        $result = array();

        if(empty($withdrawal_point)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['出金完了情報の論理削除に失敗しました'],
            );
        } else {
            $result = array(
                'status_code' => 200,
            );

            $withdrawal_point->delete();
        }

        return response()->json($result);
    }
}
