<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreBankRequest extends FormRequest
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
        $bank_type = $request->bank_type;
        if($bank_type == 0) {
            return [
                'point'        => 'required',
                'fee'          => 'required',
                'transfer'     => 'required',
                'bank_type'    => 'required',
                // ゆうちょ銀行情報
                'japan_mark'   => 'required|digits:5',
                'japan_number' => 'required|digits_between:7, 8',
                'japan_name'   => 'required|max:255',
            ];
        } elseif($bank_type == 1) {
            return [
                'point'        => 'required',
                'fee'          => 'required',
                'transfer'     => 'required',
                'bank_type'    => 'required',
                // その他銀行情報
                'financial_name' => 'required|max:100',
                'shop_name'    => 'required|max:100',
                'shop_number'  => 'required|digits:3',
                'other_type'     => 'required',
                'other_number'   => 'required|digits:7',
                'other_name'     => 'required|max:255',
            ];
        }
        // return [
        //     // ゆうちょ銀行情報
        //     'japan_mark'   => 'required|digits:5',
        //     'japan_number' => 'required|digits_between:7, 8',
        //     'japan_name'   => 'required|max:255',
        //     // その他銀行情報
        //     'financial_name' => 'required|max:100',
        //     'shop_name'    => 'required|max:100',
        //     'shop_number'  => 'required|digits:3',
        //     'other_type'     => 'required',
        //     'other_number'   => 'required|digits:7',
        //     'other_name'     => 'required|max:255',
        // ];
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages()
    {
        // if($bank_type ==  0) {
        //     return [
        //         // ゆうちょ銀行
        //         'japan_mark.required'         => '口座記号は必須です。',
        //         'japan_mark.max'              => '口座記号は半角数字で5文字以内です。',
        //         'japan_number.required'       => '口座番号は必須です。',
        //         'japan_number.digits_between' => '口座番号は半角数字で8文字以内です。',
        //         'japan_name.required'         => '口座名義人は必須です。',
        //         'japan_name.max'              => '口座名義人は255文字以内です。',
        //     ];
        // } elseif($bank_type == 1) {
        //     return [
        //         // その他銀行情報
        //         'financial_name.required' => '金融機関名は必須です。',
        //         'financial_name.max' => '金融機関名は255文字以内です。',
        //         'shop_name.required' => '支店名は必須です。',
        //         'shop_name.max' => '支店名は255文字以内です。',
        //         'shop_number.required' => '支店番号は必須です。',
        //         'shop_number.digits' => '支店番号は半角数字で3文字です。',
        //         'other_type.required' => '口座種別は必須です。',
        //         'other_number.required' => '口座番号は必須です。',
        //         'other_number.digits' => '口座種別は半角数字で7文字です。',
        //         'other_name.required' => '口座名義人は必須です。',
        //         'other_name.digits' => '口座名義人は100文字以内です。',
        //     ];
        // }
        return [
            // 共通
            'point'                       => '金額は必須です。',
            'fee'                         => '手数料は必須です。',
            'bank_type'                   => '銀行タイプは必須です。',
            'transfer'                    => '振込金額は必須です。',
            // ゆうちょ銀行
            'japan_mark.required'         => '口座記号は必須です。',
            'japan_mark.digits'           => '口座記号は半角数字で5文字以内です。',
            'japan_number.required'       => '口座番号は必須です。',
            'japan_number.digits_between' => '口座番号は半角数字で8文字以内です。',
            'japan_name.required'         => '口座名義人は必須です。',
            'japan_name.max'              => '口座名義人は255文字以内です。',

            // その他銀行情報
            'financial_name.required' => '金融機関名は必須です。',
            'financial_name.max' => '金融機関名は255文字以内です。',
            'shop_name.required' => '支店名は必須です。',
            'shop_name.max' => '支店名は255文字以内です。',
            'shop_number.required' => '支店番号は必須です。',
            'shop_number.digits' => '支店番号は半角数字で3文字です。',
            'other_type.required' => '口座種別は必須です。',
            'other_number.required' => '口座番号は必須です。',
            'other_number.digits' => '口座種別は半角数字で7文字です。',
            'other_name.required' => '口座名義人は必須です。',
            'other_name.digits' => '口座名義人は100文字以内です。',
        ];
    }
}
