@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', '販売代行依頼 STEP2 | モアクロ')
@section('description', '販売代行依頼 STEP2')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="販売代行依頼 STEP2"
    back="/custody/sales-agency/request"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>
{{-- モーダル：販売代行手数料 --}}
<div id="sales-commission-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h2 class="uk-modal-title">販売代行手数料</h2>
        <p>販売代行手数料販売代行手数料販売代行手数料</p>
    </div>
</div>

{{-- モーダル：送料 --}}
<div id="shipping-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h2 class="uk-modal-title">送料</h2>
        <p>送料送料送料</p>
    </div>
</div>

{{--  モーダル：荷物を寄付する  --}}
<div id="modal-donate" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">寄付をする</h2>
        <p>（荷物の権利は、モアクロに属することになります。）</p>
        <form method="POST" action="{{ route('custody.item.donate', ['id' => $input_items['item_id']]) }}">
            @csrf
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">戻る</button>
                <button class="uk-button uk-button-primary" type="submit">寄付する</button>
            </p>
        </form>
    </div>
</div>

<section class="user__content">
    <div class="user__content__headline">
        <div class="user__content__headline__inner complete-message">
            <div class="step-box">
                <span class="step-box-number one">１</span>
                <span class="step-box-number two now">２</span>
                <span class="step-box-number three">３</span>
            </div>
            <p>希望する条件を選択してください。</p>
        </div>
    </div>
</section>

<form method="POST" action="{{ route('custody.sales.request.two.post') }}">
    @csrf
    <input type="hidden" name="item_id" value="{{ $input_items['item_id'] }}">
    <input type="hidden" name="url" value="{{ $input_items['url'] }}">
    <section class="user__content">
        <div class="user__content__headline">
            <div class="user__content__headline__inner l-flex l-v__center">
                <p>選択した荷物</p>
            </div>
        </div>
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <div class="item__img">
                        <div class="item__img__inner">
                            <img src="{{ $input_items['url'] ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="user__content">
        <div class="user__content__headline">
            <div class="user__content__headline__inner l-flex l-v__center">
                <p>寄付する！</p>
            </div>
        </div>
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <div class="uk-form-controls">
                        <a class="c-button c-button--pink u-w100per" href="#modal-donate" uk-toggle>荷物を寄付する！</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="user__content">
        <div class="user__content__headline">
            <div class="user__content__headline__inner l-flex l-v__center">
                <p>販売代行 最低希望金額</p>
            </div>
        </div>
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <div class="uk-margin">
                        <div class="uk-form-controls">
                            <select name="price" class="uk-select user__content__box__gray__inner" id="form-horizontal-select">
                                <option value="0" @if(isset($input_items['price']) && $input_items['price'] === 0) selected="selected" @endif>寄付する！</option>
                                @for ($i = 3000; $i <= 10000; $i += 500)
                                <option value="{{ $i }}" @if(isset($input_items['price']) && $input_items['price'] == $i) selected="selected" @endif>{{ number_format($i) }}円以上</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <table>
                        <tr>
                            <td class="u-text--sub">※</td>
                            <td class="u-text--sub">手元に残るお金は、販売代金から「販売手数料」及び「送料」を差し引いた金額です。おおよそ、販売価格の15~30%が、ユーザー様の取り分となります。</td>
                        </tr>
                        <tr>
                            <td class="u-text--sub">※</td>
                            <td class="u-text--sub">3,000円未満の場合は、販売できません。</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section> --}}
    <section class="user__content">
        <div class="user__content__headline">
            <div class="user__content__headline__inner l-flex l-v__center">
                <p>その他リクエスト</p>
            </div>
        </div>
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <textarea name="request" class="uk-input user__content__box__gray__inner" value="{{ $input_items['request'] ?? '' }}">{{ $input_items['request'] ?? '' }}</textarea>
                </div>
            </div>
        </div>
    </section>
    <section class="user__content">
        <div class="user__content__headline">
            <div class="user__content__headline__inner l-flex l-v__center">
                <p>注意事項</p>
            </div>
        </div>
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <div class="uk-alert-danger" uk-alert>
                        <table>
                            <tr>
                                <td>１．</td>
                                <td>リクエスト後、スタッフが販売可能かどうか確認します。万が一、販売が難しい場合は、リクエストを取り消させていただきます。</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="user__content">
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__list l-flex">
                    <div class="u-w49per">
                        <button class="c-button c-button--big c-button--pink" name="back" type="submit">前の画面に戻る</button>
                    </div>
                    <div class="u-w49per">
                        <button class="c-button c-button--big c-button--bgBlue" type="submit">確認画面へ進む</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
@endsection
