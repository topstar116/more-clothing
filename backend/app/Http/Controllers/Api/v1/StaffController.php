<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApiStoreStaffRequest;
use App\Models\Staff;

class StaffController extends Controller
{
    public function index(Request $request) {
        $result = array(
            'status_code' => 200,
            'params' => array('staffs' => Staff::all()),
        );

        return response()->json($result);
    }

    public function show(Request $request, $staff_id) {
        $staff = Staff::findByID($staff_id);
        $result = array();

        if(empty($staff)) {
            $result = array(
                'status_code' => 400,
            );
        } else {
            $result = array(
                'status_code' => 200,
                'params' => array('staff' => $staff),
            );
        }

        return response()->json($result);
    }

    public function store(ApiStoreStaffRequest $request) {
        $data = array(
            'shop_id' => $request->post('shop_id'),
            'last_name' => $request->post('last_name'),
            'first_name' => $request->post('first_name'),
            'last_name_kana' => $request->post('last_name_kana'),
            'first_name_kana' => $request->post('first_name_kana'),
            'email' => $request->post('email'),
            'memo' => $request->post('memo'),
        );
        $result = array();

        try {
            $staff = new Staff($data);
            $staff->save();

            $result = array(
                'status_code' => 200,
            );
        } catch (\Exception $e) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['スタッフの登録に失敗しました。'],
            );
        }

        return response()->json($result);
    }

    public function update(ApiStoreStaffRequest $request, $staff_id) {
        $data = array(
            'shop_id' => $request->post('shop_id'),
            'last_name' => $request->post('last_name'),
            'first_name' => $request->post('first_name'),
            'last_name_kana' => $request->post('last_name_kana'),
            'first_name_kana' => $request->post('first_name_kana'),
            'email' => $request->post('email'),
            'memo' => $request->post('memo'),
        );
        $result = array();

        try {
            $staff = Staff::findByID($staff_id);

            $staff->shop_id = $data['shop_id'];
            $staff->last_name = $data['last_name'];
            $staff->first_name = $data['first_name'];
            $staff->last_name_kana = $data['last_name_kana'];
            $staff->first_name_kana = $data['first_name_kana'];
            $staff->email = $data['email'];
            $staff->memo = $data['memo'];

            $shop->save();

            $result = array(
                'status_code' => 200,
            );
        } catch (\Exception $e) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['スタッフの更新に失敗しました。'],
            );
        }

        return response()->json($result);
    }

    public function delete(Request $request, $staff_id) {
        $staff = Staff::findByID($staff_id);
        $result = array();

        if(empty($staff)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['スタッフの削除に失敗しました。'],
            );
        } else {
            $result = array(
                'status_code' => 200,
            );

            $staff->delete();
        }

        return response()->json($result);
    }
}
