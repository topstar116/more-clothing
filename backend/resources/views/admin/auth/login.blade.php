@extends('layouts.page')

<!-- タイトル・メタディスクリプション -->
@section('title', '管理者ログイン画面 | モアクロ')
@section('description', '管理者ログイン画面')

<!-- CSS -->
@push('css')
<link rel="stylesheet" href="{{ asset('css/page/other.css') }}">
@endpush

<!-- 本文 -->
@section('content')
    <section class="other__screen">
        <div class="l-wrap">
            <h1>ログイン</h1>
        </div>
    </section>
    <section class="other__content page__login">
        <div class="l-wrap">
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="other__content__login">
                    <div class="other__content__login__inner">
                        <label>メールアドレス</label>
                        <div><input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="info@more-clothing.site"></div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="other__content__login">
                    <div class="other__content__login__inner">
                        <label>パスワード</label>
                        <div><input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="*************"></div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="other__content__login">
                    <div class="other__content__login__inner">
                        <button type="submit" class="btn btn-primary">ログイン</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection