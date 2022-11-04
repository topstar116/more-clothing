<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestReturns;
use App\Http\Requests\ApiStoreRequestReturnRequest;

class RequestReturnController extends Controller
{
    public function store(ApiStoreRequestReturnRequest $request) {
        $data = array(
            'item_id' => $request->post('item_id'),
            'return_on' => $request->post('return_on'),
            'detail' => $request->post('detail'),
        );
        $result = array();

        try {
            $request_return = new RequestReturns($data);
            $request_return->save();

            $result = array(
                'status_code' => 200,
            );
        } catch (\Exception $e) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['返却リクエストの登録に失敗しました。'],
            );
        }

        return response()->json($result);
    }

    public function delete(Request $request, $request_return_id) {
        $request_return = RequestReturns::findByID($request_return_id);
        $result = array();

        if(empty($request_return)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['返却リクエストの削除に失敗しました。'],
            );
        } else {
            $result = array(
                'status_code' => 200,
                'success_messages' => ['返却リクエストを取り消しました。'],
            );

            $request_return->delete();
        }

        return response()->json($result);
    }

    public function show(Request $request, $item_id) {
        if(empty($item_id)) {
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        $items = RequestReturns::findByItemId($item_id);

        $result = array();

        if(empty($item)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['返却リクエスト詳細の取得に失敗しました。'],
            );
        } else {
            $result = array(
                'status_code' => 200,
                'success_messages' => ['返却リクエスト詳細の取得に成功しました。'],
                'params' => array(' return_requests' => $items),
            );
        }

        return response()->json($result);
    }
}
