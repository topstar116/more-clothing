@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', '出金リクエスト確認 | モアクロ')
@section('description', '出金リクエスト確認')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="出金リクエスト確認"
    back="/custody/payment/request"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>

<section class="user__content">
    <div class="user__content__headline">
        <div class="user__content__headline__inner l-flex l-v__center">
            <p>出金額</p>
        </div>
    </div>
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__gray">
                <table class="uk-table uk-table-small u-mb0">
                    <tr>
                        <th style="width: 100px;">申請金額</th>
                        <td>{{ number_format($input['point']) }}円</td>
                    </tr>
                    <tr class="border">
                        <th>手数料</th>
                        <td>{{ number_format($input['fee']) }}円</td>
                    </tr>
                    <tr>
                        <th>振込金額</th>
                        <td>{{ number_format($input['transfer']) }}円</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</section>
<section class="user__content">
    <div class="user__content__headline">
        <div class="user__content__headline__inner l-flex l-v__center">
            <p>振込先情報</p>
        </div>
    </div>
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__gray">
                <table class="uk-table uk-table-small u-mb0">
                    @if($input['bank_type'] == 0)
                    <tr>
                        <th style="width: 100px;">金融機関名</th>
                        <td>ゆうちょ銀行</td>
                    </tr>
                    <tr>
                        <th>口座記号</th>
                        <td>{{ $input['japan_mark'] }}</td>
                    </tr>
                    <tr>
                        <th>口座番号</th>
                        <td>{{ $input['japan_number'] }}</td>
                    </tr>
                    <tr>
                        <th>口座名義人</th>
                        <td>{{ $input['japan_name'] }}</td>
                    </tr>
                    @elseif($input['bank_type'] == 1)
                    <tr>
                        <th style="width: 100px;">金融機関名</th>
                        <td>{{ $input['financial_name'] }}</td>
                    </tr>
                    <tr>
                        <th>支店名</th>
                        <td>{{ $input['shop_name'] }}</td>
                    </tr>
                    <tr>
                        <th>支店番号</th>
                        <td>{{ $input['shop_number'] }}</td>
                    </tr>
                    <tr>
                        <th>口座種別</th>
                        <td>
                            @if($input['other_type'] == 0)普通
                            @elseif($input['other_type'] == 1)当座
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>口座番号</th>
                        <td>{{ $input['other_number'] }}</td>
                    </tr>
                    <tr>
                        <th>口座名義人</th>
                        <td>{{ $input['other_name'] }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</section>
<section class="user__content">
    <form method="POST" action="{{ route('custody.payment.request.confirm.post') }}">
    @csrf
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__list l-flex">
                <div class="u-w49per">
                    <button class="c-button c-button--big c-button--pink" type="submit" name="back">前の画面に戻る</button>
                </div>
                <div class="u-w49per">
                    <button class="c-button c-button--big c-button--bgBlue" type="submit">出金依頼する</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
