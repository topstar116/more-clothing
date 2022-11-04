<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HistoryDonation;

class HistoryDonationController extends Controller
{
    public function store(Request $request) {
        $data = array(
            'item_id' => $request->post('item_id'),
            'memo' => '',
        );
        $result = array();

        try {
            $history_sale = new HistoryDonation($data);
            $history_sale->save();

            $result = array(
                'status_code' => 200,
                'success_messages' => ['寄付が完了しました。'],
            );
        } catch (\Exception $e) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['寄付に失敗しました。'],
            );
        }

        return response()->json($result);
    }

    public function show(Request $request, $blog_id) {
        if(empty($blog_id)) {
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        $blogs = HistoryDonation::findByBlogId($blog_id);

        $result = array();

        if(empty($blogs)) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['販売情報の取得に失敗しました。'],
            );
        } else {
            $result = array(
                'status_code' => 200,
                'error_messages' => ['販売情報の取得に成功しました。'],
                'params' => array('blogs' => $blogs),
            );
        }

        return response()->json($result);
    }
}
