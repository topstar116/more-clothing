<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistoryRentalController extends Controller
{
    public function show(Request $request, $item_id) {
        if(empty($item_id)) {
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        $items = HistoryRental::findByItemId($item_id);

        $result = array();

        if(empty($item)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['販売情報の取得に失敗しました。'],
            );
        } else {
            $result = array(
                'status_code' => 200,
                'success_messages' => ['返却情報の取得に成功しました。'],
                'params' => array('history_rental' => $items),
            );
        }

        return response()->json($result);
    }
}
