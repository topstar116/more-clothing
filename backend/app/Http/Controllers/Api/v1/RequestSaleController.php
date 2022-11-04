<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApiStoreRequestSaleRequest;
use App\Models\RequestSale;

class RequestSaleController extends Controller
{
    public function store(ApiStoreRequestSaleRequest $request) {
        $data = array(
            'item_id' => $request->post('item_id'),
            'detail' => $request->post('detail'),
        );
        $result = array();

        try {
            $request_sale = new RequestSale($data);
            $request_sale->save();

            $result = array(
                'status_code' => 200,
                'success_messages' => ['販売リクエストを受け付けました。'],
            );
        } catch (\Exception $e) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['販売リクエストの登録に失敗しました。'],
            );
        }

        return response()->json($result);
    }

    public function show(Request $request, $item_id) {
        if(empty($item_id)) {
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        $items = RequestSale::findByItemId($item_id);

        $result = array();

        if(empty($item)) {
            $result = array(
                'status_code' => 400,
            );
        } else {
            $result = array(
                'status_code' => 200,
                'error_messages' => ['販売依頼詳細の取得に成功しました。'],
                'params' => array(' request_sales' => $items),
            );
        }

        return response()->json($result);
    }
}
