<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Box;

class BoxController extends Controller
{
    public function index(Request $request) {
        
        if(auth()->guard('api')->check()){
            $user_id = auth()->user()->id;

            $result = array(
                'status_code' => 200,
                'params' => array('boxes' =>  Box::getBoxesByUser($user_id)),
            );
        } elseif (auth()->guard('api_manager')->check()) {
            $result = array(
                'status_code' => 200,
                'params' => array('boxes' =>  Box::all()),
            );
        }

        return response()->json($result);
    }

    public function delete(Request $request, $box_id) {
        $box = Box::findByID($box_id);
        $result = array();

        // if (auth()->guard('api_manager')->check()) {
            

        // }

        if(empty($box)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['箱の削除に失敗しました。'],
            );
        } else {
            $result = array(
                'status_code' => 200,
            );

            $box->delete();
        }

        return response()->json($result);
    }

    public function show(Request $request, $box_id) {
        if(empty($user_id)) {
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        $boxs = Box::findByBoxId($box_id);

        $result = array();

        if(empty($bank)) {
            $result = array(
                'status_code' => 400,
            );
        } else {
            $result = array(
                'status_code' => 200,
                'params' => array('box' => $boxs),
            );
        }

        return response()->json($result);
    }
}
