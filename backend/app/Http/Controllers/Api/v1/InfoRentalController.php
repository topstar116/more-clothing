<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApiStoreInfoRentalRequest;
use App\Models\InfoRental;

class InfoRentalController extends Controller
{
    public function index(Request $request) {
        $result = array(
            'status_code' => 200,
            'params' => array('info_rentals' => InfoRental::all()),
        );

        return response()->json($result);
    }

    public function store(ApiStoreInfoRentalRequest $request) {
        $data = array(
            'item_id' => $request->post('item_id'),
            'staff_id' => $request->post('staff_id'),
            'price' => $request->post('price'),
            'title' => $request->post('title'),
            'detail' => $request->post('detail'),
        );
        $result = array();

        try {
            $info_rental = new InfoRental($data);
            $info_rental->save();

            $result = array(
                'status_code' => 200,
            );
        } catch (\Exception $e) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['レンタル情報の登録に失敗しました。'],
            );
        }

        return response()->json($result);
    }

    public function delete(Request $request, $item_id) {
        $info_rental = InfoRental::findByID($item_id);
        $result = array();

        if(empty($info_rental)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['レンタル情報の削除に失敗しました。'],
            );
        } else {
            $result = array(
                'status_code' => 200,
            );

            $info_rental->delete();
        }

        return response()->json($result);
    }

    public function show(Request $request, $item_id) {
        if(empty($item_id)) {
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        $items = InfoRental::findByItemId($item_id);

        $result = array();

        if(empty($item)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['販売依頼詳細の取得に失敗しました。']
            );
        } else {
            $result = array(
                'status_code' => 200,
                'error_messages' => ['販売依頼詳細の取得に成功しました。'],
                'params' => array('info_rentals' => $items),
            );
        }

        return response()->json($result);
    }
}
