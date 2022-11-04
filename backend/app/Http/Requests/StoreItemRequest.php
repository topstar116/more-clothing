<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'box_id'         => 'required',
            'item_id'         => 'required',
            'memo'           => 'max:1000',
            'how'            => 'required',
            'img1'           => 'image|mimes:jpeg,png,jpg,gif|max:10485760',
            'img2'           => 'image|mimes:jpeg,png,jpg,gif|max:10485760',
            'img3'           => 'image|mimes:jpeg,png,jpg,gif|max:10485760',
            'img4'           => 'image|mimes:jpeg,png,jpg,gif|max:10485760',
            'img5'           => 'image|mimes:jpeg,png,jpg,gif|max:10485760',
        ];
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages()
    {
        return [
            'shop_id.required' => '支店情報は必須です。',
            'Staff_id.required' => '担当者情報は必須です。',
            'add_id.required'    => '箱の情報は必須です。',
            'how.required'       => '保管方法は必須です。',
            'item_detail.max'    => '箱詳細は1000文字いないです。',
            'img1.image'         => '1枚目の画像が、指定されたファイルではありません。',
            'img1.mimes'         => '画像ファイルはjpeg,png,jpg,gifのみです。',
            'img1.max'           => '1枚目の画像サイズが2Mを超えています。',
            'img2.image'         => '2枚目の画像が、指定されたファイルではありません。',
            'img2.mimes'         => '画像ファイルはjpeg,png,jpg,gifのみです。',
            'img2.max'           => '2枚目の画像サイズが2Mを超えています。',
            'img3.image'         => '3枚目の画像が、指定されたファイルではありません。',
            'img3.mimes'         => '画像ファイルはjpeg,png,jpg,gifのみです。',
            'img3.max'           => '3枚目の画像サイズが2Mを超えています。',
            'img4.image'         => '4枚目の画像が、指定されたファイルではありません。',
            'img4.mimes'         => '画像ファイルはjpeg,png,jpg,gifのみです。',
            'img4.max'           => '4枚目の画像サイズが2Mを超えています。',
            'img5.image'         => '5枚目の画像が、指定されたファイルではありません。',
            'img5.mimes'         => '画像ファイルはjpeg,png,jpg,gifのみです。',
            'img5.max'           => '5枚目の画像サイズが2Mを超えています。',
        ];
    }
}
