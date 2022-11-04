@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', 'アカウント情報編集 | モアクロ')
@section('description', 'アカウント情報編集')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="アカウント情報編集"
    back="<?php echo $_SERVER['HTTP_REFERER']; ?>"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>

{{--  サクセスメッセージ  --}}
@if(session('success-message'))
<section class="user__content">
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__gray">
                <div class="uk-alert-success u-mb0" uk-alert>
                    {{ session('success-message') }}
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{--  エラーメッセージ  --}}
@if ($errors->any())
<section class="user__content">
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__gray">
                <div class="uk-alert-danger" uk-alert>
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

{{--  本文  --}}
<form method="POST" action="{{ route('custody.account.update') }}">
    @csrf
    <section class="user__content">
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <p class="sub-headline">お名前</p>
                    <div class="l-flex">
                        <div class="u-w49per"><input name="name1" class="uk-input user__content__box__gray__inner" value="{{ $user->name1 }}"></div>
                        <div class="u-w49per"><input name="name2" class="uk-input user__content__box__gray__inner" required value="{{ $user->name2 }}"></div>
                    </div>
                </div>
                <div class="user__content__box__gray">
                    <p class="sub-headline">カナ</p>
                    <div class="l-flex">
                        <div class="u-w49per"><input name="kana1" class="uk-input user__content__box__gray__inner" required value="{{ $user->kana1 }}"></div>
                        <div class="u-w49per"><input name="kana2" class="uk-input user__content__box__gray__inner" required value="{{ $user->kana2 }}"></div>
                    </div>
                </div>
                <div class="user__content__box__gray">
                    <p class="sub-headline">メールアドレス</p>
                    <input name="email" class="uk-input user__content__box__gray__inner" required value="{{ $user->email }}">
                </div>
                <div class="user__content__box__gray">
                    <p class="sub-headline">電話番号</p>
                    <input name="tel" class="uk-input user__content__box__gray__inner" required value="{{ $user->tel }}">
                </div>
                <div class="user__content__box__gray">
                    <p class="sub-headline">郵便番号</p>
                    <input name="post" class="uk-input user__content__box__gray__inner" required value="{{ $user->post }}">
                </div>
                <div class="user__content__box__gray">
                    <p class="sub-headline">住所1</p>
                    <input name="address1" class="uk-input user__content__box__gray__inner" required value="{{ $user->address1 }}">
               </div>
                <div class="user__content__box__gray">
                    <p class="sub-headline">住所2</p>
                   <input name="address2" class="uk-input user__content__box__gray__inner" required value="{{ $user->address2 }}">
                </div>
            </div>
        </div>
    </section>
    <section class="user__content">
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__list l-flex">
                    <div class="u-w49per">
                        <a href="{{ route('custody.account') }}" class="c-button c-button--big c-button--pink">前の画面に戻る</a>
                    </div>
                    <div class="u-w49per">
                        <button class="c-button c-button--big c-button--bgBlue" type="submit">アカウント更新</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
@endsection