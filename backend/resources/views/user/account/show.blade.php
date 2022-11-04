@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', 'アカウント情報 | モアクロ')
@section('description', 'アカウント情報')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="アカウント情報"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>

{{-- エラーメッセージ --}}
@if(count($errors) > 0)
<div class="container mt-2">
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
</div>
@endif

{{-- 更新成功メッセージ --}}
@if (session('update_password_success'))
<div class="container mt-2">
    <div class="alert alert-success">
        {{session('update_password_success')}}
    </div>
</div>
@endif

{{--  本文  --}}

<section class="user__content">
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">お名前</div>
                <div class="u-wflex1">{{ $user->last_name }} {{ $user->first_name }}</div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">カナ</div>
                <div class="u-wflex1">{{ $user->last_name_kana }} {{ $user->first_name_kana }}</div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">メールアドレス</div>
                <div class="u-wflex1">{{ $user->email }}</div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">パスワード</div>
                <div class="u-wflex1"><a class="u-text--link" href="{{ route('custody.account.password') }}">パスワードの変更はコチラ</a></div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">電話番号</div>
                <div class="u-wflex1">{{ $user->phone_number }}</div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">郵便番号</div>
                <div class="u-wflex1">{{ $user->postcode }}</div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">住所</div>
                <div class="u-wflex1">{{ $user->city }}<br>{{ $user->block }}</div>
            </div>
        </div>
    </div>
</section>
<section class="user__content">
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__list l-flex">
                <div class="u-w49per">
                    <a href="{{ route('custody.account.withdrawal') }}" class="c-button c-button--big c-button--default">退会する</a>
                </div>
                <div class="u-w49per">
                    <a class="c-button c-button--big c-button--blue" href="{{ route('custody.account.edit') }}">編集する</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
