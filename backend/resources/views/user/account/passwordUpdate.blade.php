@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', 'パスワード変更 | モアクロ')
@section('description', 'パスワード変更')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="パスワード変更"
    back="<?php echo $_SERVER['HTTP_REFERER']; ?>"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>

{{--  本文  --}}
<form method="POST" action="{{ route('custody.account.password.post') }}">
    @csrf
    <section class="user__content">
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <p>現在のパスワード</p>
                    <input id="current" type="password" class="uk-input user__content__box__gray__inner" name="current-password" required autofocus>
                </div>
                <div class="user__content__box__gray">
                    <p>新パスワード</p>
                    <input id="password" type="password" class="uk-input user__content__box__gray__inner" name="new-password" required>
                </div>
                <div class="user__content__box__gray">
                    <p>確認用 新パスワード</p>
                    <input id="confirm" type="password" class="uk-input user__content__box__gray__inner" name="new-password_confirmation" required>
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
                        <button class="c-button c-button--big c-button--bgBlue" type="submit">パスワード登録</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
@endsection