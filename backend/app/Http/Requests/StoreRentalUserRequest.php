<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRentalUserRequest extends FormRequest
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
        // バリデーションチェック時、自分のメールアドレスは通過
        // $myEmail = $request->email;
        return [
            'manager_id' => 'required',
            'name1'      => 'required|max:100',
            'name2'      => 'required|max:100',
            'kana1'      => 'required|max:100',
            'kana2'      => 'required|max:100',
            'email'      => 'required|max:255',
            // 'email'      => [Rule::unique('rental_users', 'email')->whereNot('email', $myEmail)],
            'tel'        => 'required|digits_between:10, 11',
            'post'       => 'required|digits:7',
            'address1'   => 'required|max:255',
            'address2'   => 'max:255',
            'memo'       => 'max:1000',
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
            'manager_id.required' => '管理者IDは必須です。',
            'name1.required' => '苗字は必須です。',
            'name1.max' => '苗字は100文字以内です。',
            'name2.required' => '名前は必須です。',
            'name2.max' => '名前は100文字以内です。',
            'kana1.required' => '苗字（カナ）は必須です。',
            'kana1.max' => '苗字（カナ）は100文字以内です。',
            'kana2.required' => '名前（カナ）は必須です。',
            'kana2.max' => '名前（カナ）は100文字以内です。',
            'email.required' => 'メールアドレスは必須です。',
            // 'email.unique' => 'メールアドレスが、他のユーザーに使用されています。',
            'email.max' => 'メールアドレスは255文字以内です。',
            'tel.required' => '電話番号は必須です。',
            'tel.digits_between' => '電話番号は数字で10〜11桁です。',
            'post.required' => '郵便番号は必須です。',
            'post.digits' => '郵便番号は数字で7桁です。',
            'address1.required' => '住所は必須です。',
            'address1.max' => '住所1は255文字以内です。',
            'address2.max' => '住所2は255文字以内です。',
            'memo'     => 'メモは1000文字以内です',
        ];
    }
}
