<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GetPoint;
use App\Models\Wallet;

class GetPointController extends Controller
{
    public function store(Request $request) {
        $point = $request->post('point');
        
        $user = auth()->user();
        $user_id = $user->id;

        $wallet = Wallet::findByID($user_id);
        $wallet_id = $wallet->id;
        
        $result = array();

        if(empty($point)){
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        try {
            $get_point = GetPoint::build($wallet_id, 0, 1, $point);
            $get_point->save();

            $result = array(
                'status_code' => 200,
            );
        } catch (\Exception $e) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['ポイントの登録に失敗しました。'],
            );
        }

        return response()->json($result);
    }

    public function delete(Request $request, $wallet_id) {
        if(empty($wallet_id)) {
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        $get_point = GetPoint::findByID($wallet_id);
        $result = array();

        if(empty($get_point)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['獲得ポイントの削除に失敗しました。'],
            );
        } else {
            $result = array(
                'status_code' => 200,
            );

            $get_point->delete();
        }

        return response()->json($result);
    }
}
