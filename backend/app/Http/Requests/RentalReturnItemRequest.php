<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class RentalReturnItemRequest extends FormRequest
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
            'return_id'      => 'required',
            'date'           => 'required',
            'rental_price'   => 'required|numeric',
            'rental_fee'     => 'required|numeric',
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
            'return_id.required'      => '荷物の選択は必須です。',
            'date.required'           => 'レンタル返却日は必須です。',
            'rental_price.required'   => 'レンタル金額は必須です。',
            'rental_price.numeric'    => 'レンタル金額は整数のみです。',
            'rental_fee.required'     => 'レンタル手数料は必須です。',
            'rental_fee.numeric'      => 'レンタル手数料は整数のみです。',
        ];
    }
}
