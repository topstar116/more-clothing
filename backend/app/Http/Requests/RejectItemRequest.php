<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class RejectItemRequest extends FormRequest
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
            'Staff'    => 'required',
            'reject_id' => 'required',
            'reason'    => 'max:1000',
            'memo'      => 'max:1000',
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
            'Staff.required'    => '担当者は必須です。',
            'reject_id.required' => 'リクエスト対象は必須です。',
            'reason.max'         => '非承認理由は1000文字以内です。',
            'memo.max'           => 'メモは1000文字以内です。',
        ];
    }
}
