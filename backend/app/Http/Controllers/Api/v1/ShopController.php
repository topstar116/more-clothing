<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApiStoreShopRequest;
use App\Models\Shop;

class ShopController extends Controller
{
    public function index(Request $request) {
        $result = array(
            'status_code' => 200,
            'params' => array('shops' => Shop::all()),
        );

        return response()->json($result);
    }

    public function show(Request $request, $shop_id) {
        $shop = Shop::findByID($shop_id);
        $result = array();

        if(empty($shop)) {
            $result = array(
                'status_code' => 400,
            );
        } else {
            $result = array(
                'status_code' => 200,
                'params' => array('shop' => $shop),
            );
        }

        return response()->json($result);
    }

    public function store(ApiStoreShopRequest $request) {
        $data = array(
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'phone_number' => $request->post('phone_number'),
            'postcode' => $request->post('postcode'),
            'city' => $request->post('city'),
        );
        $result = array();

        try {
            $shop = new Shop($data);
            $shop->save();

            $result = array(
                'status_code' => 200,
            );
        } catch (\Exception $e) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['店舗の登録に失敗しました。'],
            );
        }

        return response()->json($result);
    }

    public function update(ApiStoreShopRequest $request, $shop_id) {
        $data = array(
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'postcode' => $request->input('postcode'),
            'city' => $request->input('city'),
        );
        $result = array();

        try {
            $shop = Shop::findByID($shop_id);

            $shop->name = $data['name'];
            $shop->email = $data['email'];
            $shop->phone_number = $data['phone_number'];
            $shop->postcode = $data['postcode'];
            $shop->city = $data['city'];

            $shop->save();

            $result = array(
                'status_code' => 200,
            );
        } catch (\Exception $e) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['店舗の更新に失敗しました。'],
            );
        }

        return response()->json($result);
    }

    public function delete(Request $request, $shop_id) {
        $shop = Shop::findByID($shop_id);
        $result = array();

        if(empty($shop)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['店舗の削除に失敗しました。'],
            );
        } else {
            $result = array(
                'status_code' => 200,
            );

            $shop->delete();
        }

        return response()->json($result);
    }
}
