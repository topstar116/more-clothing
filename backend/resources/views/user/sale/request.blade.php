@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', '販売代行依頼 STEP1 | モアクロ')
@section('description', '販売代行依頼 STEP1')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="販売代行依頼 STEP1"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>

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

<section class="user__content">
    <div class="user__content__headline">
        <div class="user__content__headline__inner complete-message">
            <div class="step-box">
                <span class="step-box-number one now">１</span>
                <span class="step-box-number two">２</span>
                <span class="step-box-number three">３</span>
            </div>
            <p>保管荷物から、販売代行を<br>依頼する商品を選択してください。</p>
        </div>
    </div>
</section>

{{-- 本文 --}}
<section class="user__content">    
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__list l-flex l-start">
                @foreach($items as $item)
                <div class="user__content__box__item">
                    <a href="{{ route('custody.sales.request.two', ['item_id' => $item->id, 'url' => $item->url]) }}">
                        <div class="item__img">
                            <div class="item__img__inner">
                                <img src="{{ $item->url }}">
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection

