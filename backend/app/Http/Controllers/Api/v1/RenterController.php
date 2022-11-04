<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Renter;

class RenterController extends Controller
{
    public function index(Request $request) {
        $result = array(
            'status_code' => 200,
            'params' => array('renters' => Renter::all()),
        );

        return response()->json($result);
    }

    public function show(Request $request, $renter_id) {
        $renter = Renter::findByID($renter_id);
        $result = array();

        if(empty($renter)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['箱詳細の取得に失敗しました。'],
            );
        } else {
            $result = array(
                'status_code' => 200,
                'params' => array('renter' => $renter),
            );
        }

        return response()->json($result);
    }

    public function store(ApiStoreRenterRequest $request) {
        $data = array(
            'last_name' => $request->post('last_name'),
            'first_name' => $request->post('first_name'),
            'last_name_kana' => $request->post('last_name_kana'),
            'first_name_kana' => $request->post('first_name_kana'),
            'email' => $request->post('email'),
            'passworad' => $request->post('password'),
            'phone_number' => $request->post('phone_number'),
            'postcode' => $request->post('postcode'),
            'city' => $request->post('city'),
            'block' => $request->post('block'),
            'memo' => $request->post('memo'),
        );
        $result = array();

        try {
            $renter = new Renter($data);
            $renter->save();

            $result = array(
                'status_code' => 200,
                'success_messages' => ['レンタルユーザーの登録に成功しました。'],
            );
        } catch (\Exception $e) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['レンタルユーザーの登録に失敗しました。'],
            );
        }

        return response()->json($result);
    }

    public function update(ApiStoreRenterRequest $request, $renter_id) {
        $data = array(
            'last_name' => $request->post('last_name'),
            'first_name' => $request->post('first_name'),
            'last_name_kana' => $request->post('last_name_kana'),
            'first_name_kana' => $request->post('first_name_kana'),
            'email' => $request->post('email'),
            'passworad' => $request->post('password'),
            'phone_number' => $request->post('phone_number'),
            'postcode' => $request->post('postcode'),
            'city' => $request->post('city'),
            'block' => $request->post('block'),
            'memo' => $request->post('memo'),
        );
        $result = array();

        try {
            $renter = Renter::findByID($renter_id);

            $renter->last_name = $data['last_name'];
            $renter->first_name = $data['first_name'];
            $renter->last_name_kana = $data['last_name_kana'];
            $renter->first_name_kana = $data['first_name_kana'];
            $renter->email = $data['email'];
            $renter->password = $data['password'];
            $renter->phone_number = $data['phone_number'];
            $renter->postcode = $data['postcode'];
            $renter->city = $data['city'];
            $renter->memo = $data['memo'];

            $renter->save();

            $result = array(
                'status_code' => 200,
                'success_messages' => ['レンタルユーザーの更新に成功しました。'],
            );
        } catch (\Exception $e) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['レンタルユーザーの更新に失敗しました。'],
            );
        }

        return response()->json($result);
    }

    public function delete(Request $request, $renter_id) {
        $renter = Renter::findByID($renter_id);
        $result = array();

        if(empty($renter)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['レンタルユーザーの削除に成功しました。'],
            );
        } else {
            $result = array(
                'status_code' => 200,
                'success_messages' => ['レンタルユーザーの削除に成功しました。'],
            );

            $renter->delete();
        }

        return response()->json($result);
    }
}
