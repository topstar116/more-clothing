<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class RentalItemRequest extends FormRequest
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
            'rental_id'      => 'required',
            'rental_user_id' => 'required',
            'Staff_id'      => 'required',
            'date'           => 'required',
            'fin'            => 'required',
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
            'rental_id.required'      => '荷物の選択は必須です。',
            'rental_user_id.required' => 'レンタルユーザーの選択は必須です。',
            'Staff_id.required'      => '担当者の選択は必須です。',
            'date.required'           => 'レンタル開始日は必須です。',
            'fin.required'            => 'レンタル終了予定日は必須です。',
            'rental_price.required'   => '金額は必須です。',
            'rental_price.numeric'    => '金額は整数のみです。',
            'rental_fee.required'     => 'レンタル手数料は必須です。',
            'rental_fee.numeric'      => 'レンタル手数料は整数のみです。',
        ];
    }
}
