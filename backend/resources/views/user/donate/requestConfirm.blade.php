@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', '寄付確認画面 | モアクロ')
@section('description', '寄付確認画面')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="寄付確認画面"
    back="/custody/donate/request/"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>
<section class="user__content">
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__info l-flex l-v__center">
                <div class="u-w60 u-mr20 u-text--bold">
                    <img src="/img/icon_cardboard.png">
                </div>
                <div class="u-wflex1 l-flex l-start">
                    <div class="user__content__box__item">
                        <div class="item__inner">
                            <img src="/img/home-service-three.jpg">
                        </div>
                    </div>
                    <div class="user__content__box__item">
                        <div class="item__inner">
                            <img src="/img/home-service-three.jpg">
                        </div>
                    </div>
                    <div class="user__content__box__item">
                        <div class="item__inner">
                            <img src="/img/home-service-three.jpg">
                        </div>
                    </div>
                    <div class="user__content__box__item">
                        <div class="item__inner">
                            <img src="/img/home-service-three.jpg">
                        </div>
                    </div>
                </div>
            </div>
            <div class="user__content__box__info l-flex l-v__center">
                <div class="u-w60 u-mr20 u-text--bold">
                    <img src="/img/icon_cardboard.png">
                </div>
                <div class="u-wflex1 l-flex l-start">
                    <div class="user__content__box__item">
                        <div class="item__inner">
                            <img src="/img/home-service-three.jpg">
                        </div>
                    </div>
                    <div class="user__content__box__item">
                        <div class="item__inner">
                            <img src="/img/home-service-three.jpg">
                        </div>
                    </div>
                    <div class="user__content__box__item">
                        <div class="item__inner">
                            <img src="/img/home-service-three.jpg">
                        </div>
                    </div>
                    <div class="user__content__box__item">
                        <div class="item__inner">
                            <img src="/img/home-service-three.jpg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="user__content">
    <div class="user__content__headline">
        <div class="user__content__headline__inner l-flex l-v__center">
            <p>その他リクエスト</p>
        </div>
    </div>
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__gray">
                <textarea class="user__content__box__gray__inner uk-input">
                </textarea>
            </div>
        </div>
    </div>
</section>
<section class="user__content">
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__list l-flex">
                <a class="c-button c-button--big c-button--bgBlue u-w100per">寄付荷物を確定する</a>
            </div>
        </div>
    </div>
</section>
@endsection
