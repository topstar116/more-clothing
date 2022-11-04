@extends('layouts.page')

<!-- タイトル・メタディスクリプション -->
@section('title', '新規登録 | モアクロ')
@section('description', '新規登録')

<!-- CSS -->
@push('css')
<link rel="stylesheet" href="{{ asset('css/page/other.css') }}">
@endpush

<!-- 本文 -->
@section('content')
<section class="other__screen">
    <div class="l-wrap">
        <h1>新規登録</h1>
    </div>
</section>

<section class="other__content page__login">
    <div class="l-wrap">
        {{-- 仮メール送信完了 --}}
        @if(session('success-message'))
        <section class="user__content u-mb20">
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

        {{-- 仮メールから登録画面への遷移失敗 --}}

        {{--  エラーメッセージ  --}}
        @if(session('verify-failed'))
        <section class="user__content u-mb20">
            <div class="user__content__box">
                <div class="user__content__box__inner">
                    <div class="user__content__box__gray">
                        <div class="uk-alert-danger u-mb0" uk-alert>
                            {{ session('verify-failed') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif

        <form method="POST" action="{{ route('email.verify.send') }}">
            @csrf
            <div class="other__content__login">
                <div class="other__content__login__inner">
                    <label>メールアドレス</label>
                    <div><input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="info@more-clothing.site"></div>
                </div>
                @error('email')
                    <div class="uk-alert-danger" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p>{{ $message }}</p>
                    </div>
                @enderror
            </div>
            <div class="other__content__login">
                <div class="other__content__login__inner">
                    <button class="c-button--square__pink" type="submit">仮登録</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection



{{--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('email.verify.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
--}}
