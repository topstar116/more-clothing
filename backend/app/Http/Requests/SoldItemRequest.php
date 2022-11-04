<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SoldItemRequest extends FormRequest
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
    public function rules()
    {
        return [
            'sell_id'   => 'required',
            'Staff_id' => 'required',
            'date'      => 'required',
            'price'     => 'required|numeric',
            'fee'       => 'required|numeric',
            'shipping'  => 'required|numeric',
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
            'sell_id.required'      => '荷物の選択は必須です。',
            'Staff_id.required'    => '担当者の選択は必須です。',
            'date.required'         => '売却日は必須です。',
            'price.required'        => '売却価格は必須です。',
            'price.numeric'         => '売却価格は整数のみです。',
            'fee.required'          => '売却手数料は必須です。',
            'fee.numeric'           => '売却手数料は整数のみです。',
            'shipping.required'     => '送料は必須です。',
            'shipping.numeric'      => '送料は整数のみです。',
        ];
    }
}
