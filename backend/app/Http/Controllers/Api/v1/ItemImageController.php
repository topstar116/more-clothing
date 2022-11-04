<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ItemImage;
use App\Http\Requests\ApiStoreItemImageRequest;

class ItemImageController extends Controller
{
    public function update(Request $request, $item_id) {
        if(empty($item_id)) {
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        $item_image = ItemImage::findByID($item_id);
        $result = array();

        if(empty($item_image)) {
            $result = array(
                'status_code' => 400,
            );
        } else {
            $result = array(
                'status_code' => 200,
            );
            $item_image->delete();
            // if(auth()->guard('api')->check()){
            //     $item_image->delete();
            // } elseif (auth()->guard('api_manager')->check()) {
            //     $item_image = public_path().'/uploads_folder/'.$file;
            //     \File::delete($item_image);
            //     $item_image->forceDelete();;
            // }
        }

        return response()->json($result);
    }

    public function delete(Request $request, $item_id) {
        if(empty($item_id)) {
            return response()->json(array(
                'status_code' => 422,
            ));
        }

        $item_image = ItemImage::findByID($item_id);
        $result = array();

        if(empty($item_image)) {
            $result = array(
                'status_code' => 400,
            );
        } else {
            $result = array(
                'status_code' => 200,
            );
            $item_image->delete();
            // if(auth()->guard('api')->check()){
            //     $item_image->delete();
            // } elseif (auth()->guard('api_manager')->check()) {
            //     $item_image = public_path().'/uploads_folder/'.$file;
            //     \File::delete($item_image);
            //     $item_image->forceDelete();;
            // }
        }

        return response()->json($result);
    }

    public function index(Request $request , $item_id) {
        
        $result = array(
            'status_code' => 200,
            'params' => array('banks' => ItemImage::findByID($item_id)),
        );

        return response()->json($result);
    }

    public function store(ApiStoreItemImageRequest $request) {
        $request_data = array(
            'item_id' => $request->post('user_id'),
            'image_url' => $request->post('type'),
        );

        $result = array();

        try {
            $item_image = new ItemImage($request_data);
            $item_image->save();

            $result = array(
                'status_code' => 200,
                'success_messages' => ['荷物画像の登録に成功しました。'],
            );
        } catch (\Exception $e) {
            $result = array(
                'status_code' => 400,
                'error_messages' => ['荷物画像の登録に失敗しました。']
            );
        }

        return response()->json($result);
    }
}
