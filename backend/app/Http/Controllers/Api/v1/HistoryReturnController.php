<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApiStoreHistoryReturnRequest;

class HistoryReturnController extends Controller
{
    public function store(ApiStoreHistoryReturnRequest $request) {
        $request_data = array(
            'item_id' => $request->post('item_id'),
            'staff_id' => $request->post('staff_id'),
            'request_on' => $request->post('request_on'),
            'carrier_name' => $request->post('carrier_name'),
            'tracking_number' => $request->post('tracking_number'),
            'estimated_arrival_on' => $request->post('estimated_arrival_on'),
            'memo' => $request->post('memo'),
        );

        $result = array();

        try {
            $item_image = new HistoryReturn($request_data);
            $item_image->save();

            $result = array(
                'status_code' => 200,
                'success_messages' => ['返却の登録に成功しました。'],
            );
        } catch (\Exception $e) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['返却の登録に失敗しました。']
            );
        }

        return response()->json($result);
    }
}
