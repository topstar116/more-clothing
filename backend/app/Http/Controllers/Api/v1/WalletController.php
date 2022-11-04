<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;

class WalletController extends Controller
{
    public function store(Request $request) {
        $user_id = $request->post('user_id');
        $request_data = array(
            'user_id' => $request->post('user_id'),
        );

        $result = array();

        if(empty($user_id)){
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        try {
            $wallet = new Wallet($request_data);
            $wallet->save();

            $result = array(
                'status_code' => 200,
            );
        } catch (\Exception $e) {
            $result = array(
                'status_code' => 400,
                'error_messages' => [''],
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

        $wallet = Wallet::findByID($user_id);
        $result = array();

        if(empty($wallet)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => [''],
            );
        } else {
            $result = array(
                'status_code' => 200,
            );

            $wallet->delete();
        }

        return response()->json($result);
    }

    public function index(Request $request){
        $result = array();
        $user_id = $request->input('user_id');
        
        if(empty($user_id)) {
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        $wallet = wallet::findByUserIdWithGetPointAndWithdrawalPoint($user_id);

        $result = array();

        if(empty($wallet)) {
            $result = array(
                'status_code' => 400,
            );
        } else {
            $result = array(
                'status_code' => 200,
                'params' => array('wallet' => $wallet),
            );
        }

        return response()->json($result);
    }

    public function indexTotal(Request $request){
        $result = array();
        $user_id = $request->input('user_id');
        
        if(empty($user_id)) {
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        $wallet = wallet::findByUserIdWithGetPointAndWithdrawalPoint($user_id);
        $total_point = $wallet;
        $result = array();
        
        if(empty($wallet)) {
            $result = array(
                'status_code' => 400,
            );
        } else {
            $result = array(
                'status_code' => 200,
                'params' => array('total_point' => $total_point),
            );
        }

        return response()->json($result);
    }


    public function indexByMonth(Request $request, $month){
        $result = array();
        $user_id = $request->input('user_id');
        
        if(empty($user_id)) {
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        $wallet = wallet::findByUserIdWithGetPointAndWithdrawalPoint($user_id);

        $result = array();

        if(empty($wallet)) {
            $result = array(
                'status_code' => 400,
            );
        } else {
            $result = array(
                'status_code' => 200,
                'params' => array('wallet' => $wallet),
            );
        }

        return response()->json($result);
    }

    public function indexByYear(Request $request, $year){
        $result = array();
        $user_id = $request->input('user_id');
        
        if(empty($user_id)) {
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        $wallet = wallet::findByUserIdWithGetPointAndWithdrawalPoint($user_id);

        $result = array();

        if(empty($wallet)) {
            $result = array(
                'status_code' => 400,
            );
        } else {
            $result = array(
                'status_code' => 200,
                'params' => array('wallet' => $wallet),
            );
        }

        return response()->json($result);
    }

    public function tradingHistory(Request $request, $wallet_id){
        $result = array();
        $user_id = $request->input('user_id');
        
        if(empty($user_id)) {
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        $wallet = wallet::findByUserIdWithGetPointAndWithdrawalPoint($user_id);

        $result = array();

        if(empty($wallet)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['取引一覧の取得に失敗しました。']
            );
        } else {
            $result = array(
                'status_code' => 200,
                'params' => array('wallet' => $wallet),
            );
        }

        return response()->json($result);   
    }
}
