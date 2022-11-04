<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function indexOfRental(Request $request , $item_id){

        if(auth()->guard('api')->check()){
            $result = array(
                'status_code' => 200,
                'params' => array('items' =>  Item::getItemsByRental($item_id)),
            );
            
            
            if(empty(Item::getItemsByRental($item_id))){
                $result = array(
                    'status_code' => 400,
                    'error_messages' => ['レンタル荷物一覧の取得に失敗しました。'],
                );
            }
        } elseif (auth()->guard('api_manager')->check()) {
            $result = array(
                'status_code' => 200,
                'params' => array('items' =>  Item::getItemsByRental($item_id)),
            );
            
            
            if(empty(Item::getItemsByRental($item_id))){
                $result = array(
                    'status_code' => 400,
                    'error_messages' => ['レンタル荷物一覧の取得に失敗しました。'],
                );
            }
        }

        return response()->json($result);
    }

    public function indexOfUser(Request $request , $user_id){

        if(auth()->guard('api')->check()){
            $result = array(
                'status_code' => 200,
                'params' => array('items' =>  Box::getBoxesByUser($user_id)),
            );
            
            
            if(empty(Box::getBoxesByUser($user_id))){
                $result = array(
                    'status_code' => 400,
                    'error_messages' => ['荷物一覧の取得に失敗しました。'],
                );
            }
        } elseif (auth()->guard('api_manager')->check()) {
            $result = array(
                'status_code' => 200,
                'params' => array('items' =>  Item::boxListOfUser($user_id)),
            );
            
            
            if(empty(Item::boxListOfUser($user_id))){
                $result = array(
                    'status_code' => 400,
                    'error_messages' => ['荷物一覧の取得に失敗しました。'],
                );
            }
        }

        return response()->json($result);
    }

    public function indexOfSale(Request $request , $item_id){
        if(auth()->guard('api')->check()){
            $result = array(
                'status_code' => 200,
                'params' => array('items' =>  Item::getItemsBySale($item_id)),
            );

            if(empty(Item::getItemsBySale($item_id))){
                $result = array(
                    'status_code' => 400,
                    'error_messages' => ['販売荷物一覧の取得に失敗しました。'],
                );
            }
        } elseif (auth()->guard('api_manager')->check()) {
            $result = array(
                'status_code' => 200,
                'params' => array('items' =>  Item::all()),
            );

            if(empty(Item::getItemsBySale($item_id))){
                $result = array(
                    'status_code' => 400,
                    'error_messages' => ['販売荷物一覧の取得に失敗しました。'],
                );
            }
        }

        return response()->json($result);
    }

    public function indexOfBox(Request $request , $box_id){

        $result = array(
            'status_code' => 200,
            'params' => array('items' =>  Item::getItemsByBox($item_id)),
        );

        if(empty(Item::getItemsByBox($item_id))){
            $result = array(
                'status_code' => 400,
                'error_messages' => ['荷物一覧の取得に失敗しました。'],
            );

            return response()->json($result);
        }
    }

    public function updateStorage(Request $request,  $withdrawal_point_id){
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

    public function updateStatus(Request $request,  $withdrawal_point_id){
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

    public function show(Request $request, $item_id) {
        if(empty($item_id)) {
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        if(auth()->guard('api')->check()){
            $item = Item::findById($item_id);
        } elseif (auth()->guard('api_manager')->check()) {
            $item = Item::findsById($item_id);
        }

        $result = array();

        if(empty($item)) {
            $result = array(
                'status_code' => 400,
            );
        } else {
            $result = array(
                'status_code' => 200,
                'params' => array('item' => $item),
            );
        }

        return response()->json($result);
    }
}
