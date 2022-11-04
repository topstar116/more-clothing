@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', 'レンタル STEP2 | モアクロ')
@section('description', 'レンタル STEP2')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="取引履歴"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>

<section class="user__content">
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__gray">
                <div class="user__content__box__gray__inner">
                    <span class="headline">残金</span>
                    <span class="result">{{ number_format($sum) }}円</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="user__content">
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__list l-flex">
                <div class="u-w100per">
                    {{--  出金リクエスト中か判定  --}}
                    @if(!$now)
                        <a class="c-button c-button--big c-button--bgBlue u-w100per" href="{{ route('custody.payment.request.confirm') }}">出金依頼</a>
                    @else
                        <div class="uk-alert-danger u-mb0" uk-alert>
                            <p class="u-textAlign__center">出金リクエスト中です。出金リクエストはできません。</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<section class="user__content">
    <div class="user__content__box">
        <div class="user__content__box__inner">
            @foreach($trades as $trade)
            <div class="user__content__box__info l-flex l-v__center l-start">
                <div class="info__text u-wflex1">
                    <div class="info__text__detail l-flex l-v__center l-start">
                        <span class="info__time">{{ $trade->created_at }}</span>
                        @if($trade->reason == 0)
                        <span class="info__state green">レンタル</span>
                        @elseif($trade->reason == 1)
                        <span class="info__state green">売買</span>
                        @elseif($trade->reason == 8)
                        <span class="info__state pink">消滅</span>
                        @elseif($trade->reason == 9)
                        <span class="info__state pink">出金</span>
                        @endif
                    </div>
                    <div class="info__text__price @if($trade->reason != 9) green @else pink @endif">{{ number_format($trade->point) }}円</div>
                </div>
                <div class="u-w60">
                    @if($trade->item_id)
                        <a href="{{ route('custody.item.detail', $trade->item_id) }}">
                            <div class="item__img">
                                <div class="item__img__inner">
                                    <img src="{{ $trade->image_url }}">
                                </div>
                            </div>
                        </a>
                    @endif
                </div>
                <div class="info__description">
                    @if($trade->reason == 0)レンタルされました。
                    @elseif($trade->reason == 1)商品が売れました。
                    @elseif($trade->reason == 8)ポイントの有効期限が切れました。
                    @elseif($trade->reason == 9)出金しました。
                    @endif
                </div>
            </div>
            @endforeach
            {{--  <div class="user__content__box__info l-flex l-v__center l-start">
                <div class="info__text u-wflex1">
                    <div class="info__text__detail l-flex l-v__center l-start">
                        <span class="info__time">2020.08.12</span>
                        <span class="info__state pink">出金</span>
                    </div>
                    <div class="info__text__price pink">2,000円</div>
                </div>
                <div class="info__description">出金しました。</div>
            </div>
            <div class="user__content__box__info l-flex l-v__center l-start">
                <div class="info__text u-wflex1">
                    <div class="info__text__detail l-flex l-v__center l-start">
                        <span class="info__time">2020.08.12</span>
                        <span class="info__state green">レンタル</span>
                    </div>
                    <div class="info__text__price green">2,000円</div>
                </div>
                <div class="u-w60">
                    <img src="/img/home-service-three.jpg">
                </div>
                <div class="info__description">レンタルしました。</div>
            </div>  --}}
        </div>
    </div>
</section>
@endsection
