@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', '販売代行依頼 STEP3 | モアクロ')
@section('description', '販売代行依頼 STEP3')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="販売代行依頼 STEP3"
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
            <p>最終確認画面です。</p>
        </div>
    </div>
</section>
<form method="POST" action="{{ route('custody.sales.request.confirm.post') }}">
    @csrf
    <input type="hidden" name="item_id" value="{{ $input['item_id'] ?? '' }}">
    <input type="hidden" name="url" value="{{ $input['url'] }}">
    {{-- <input type="hidden" name="price" value="{{ $input['price'] }}"> --}}
    <input type="hidden" name="request" value="{{ $input['request'] }}">

    {{--  エラーメッセージ  --}}
    @if ($errors->any())
    <section class="user__content">
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <div class="uk-alert-danger u-mb0" uk-alert>
                        <ul class="u-pl0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- 本文 --}}
    <section class="user__content">
        <div class="user__content__headline">
            <div class="user__content__headline__inner l-flex l-v__center">
                <p>販売代行 商品画像</p>
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
    {{-- <section class="user__content">
        <div class="user__content__headline">
            <div class="user__content__headline__inner l-flex l-v__center">
                <p>販売代行 最低希望金額</p>
            </div>
        </div>
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    @if($input['price'] == 0)
                    <p>寄付をする</p>
                    @else
                    <p>{{ number_format($input['price']) }}円以下で販売希望</p>
                    @endif
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
                    <p>{{ $input['request'] }}</p>
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
                        <button class="c-button c-button--big c-button--bgBlue" type="submit">販売代行を依頼する</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
@endsection
