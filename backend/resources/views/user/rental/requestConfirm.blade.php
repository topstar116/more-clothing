@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', 'レンタル出品 STEP3 | モアクロ')
@section('description', 'レンタル出品 STEP3')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="レンタル出品 STEP3"
    back="/custody/sales-agency/request"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>
<section class="user__content">
    <div class="user__content__headline">
        <div class="user__content__headline__inner complete-message">
            <div class="step-box">
                <span class="step-box-number one">１</span>
                <span class="step-box-number two">２</span>
                <span class="step-box-number three now">３</span>
            </div>
            <p>確認画面です。</p>
        </div>
    </div>
</section>
<form method="POST" action="{{ route('custody.rental.request.confirm.post') }}">
    @csrf
    <section class="user__content">
        <div class="user__content__headline">
            <div class="user__content__headline__inner l-flex l-v__center">
                <p>レンタル掲載画像</p>
            </div>
        </div>
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <div class="item__img">
                        <div class="item__img__inner">
                            <img src="{{ $input['url'] }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="user__content">
        <div class="user__content__headline">
            <div class="user__content__headline__inner l-flex l-v__center">
                <p>レンタル最低希望金額</p>
            </div>
        </div>
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <p>{{ number_format($input['price']) }}円</p>
                </div>
            </div>
        </div>
    </section>
    {{--  <section class="user__content">
        <div class="user__content__headline">
            <div class="user__content__headline__inner l-flex l-v__center">
                <p>商品名</p>
            </div>
        </div>
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <p>{{ $input['name'] }}</p>
                </div>
            </div>
        </div>
    </section>  --}}
    <section class="user__content">
        <div class="user__content__headline">
            <div class="user__content__headline__inner l-flex l-v__center">
                <p>その他リクエスト</p>
            </div>
        </div>
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <p>{{ $input['other'] }}</p>
                </div>
            </div>
        </div>
    </section>
    <section class="user__content">
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__list l-flex">
                    <div class="u-w49per">
                        <button class="c-button c-button--big c-button--pink" type="submit" name="back">前の画面に戻る</button>
                    </div>
                    <div class="u-w49per">
                        <button class="c-button c-button--big c-button--bgBlue" type="submit">レンタルに出品</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
@endsection
