@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', '荷物保管依頼 連絡先 | モアクロ')
@section('description', '荷物保管依頼 連絡先')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="荷物保管依頼 連絡先"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>
<section class="user__content">
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__info">
                <p class="u-mb0">１．運営者に連絡<br>info@more-clothing.site</p>
            </div>
            <div class="user__content__box__info">
                <p class="u-mb10">２．商品を発送</p>
                <table>
                    <tr class="u-mb10">
                        <td class="u-pr20 u-pb5">宛先</td>
                        <td class="u-pb5">株式会社K-WEST</td>
                    </tr>
                    <tr>
                        <td class="u-pr20 u-pb5">電話番号</td>
                        <td class="u-pb5">075-932-1006</td>
                    </tr>
                    <tr>
                        <td class="u-pr20 u-pb5">郵送先</td>
                        <td class="u-pb5">〒617-0002<br>向日市寺戸町向畑52-5<br>イーグルハウスビル3階</td>
                    </tr>
                </table>
                <p class="u-mb0 u-mt10">※ 送料の負担はご自身でお願いいたします。</p>
            </div>
        </div>
    </div>
</section>
@endsection