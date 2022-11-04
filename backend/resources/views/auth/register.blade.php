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
        <form method="POST" action="{{ route('sign-up.store', ['token' => $token]) }}">
            @csrf
            <div class="other__content__login">
                <div class="other__content__login__inner">
                    <label>メールアドレス</label>
                    <div><input id="email" type="email" class="uk-input form-control @error('email') is-invalid @enderror" name="email" value="{{ $email }}" required autocomplete="email" readonly></div>
                </div>
            </div>
            <div class="other__content__login">
                <div class="other__content__login__inner">
                    <label>パスワード</label>
                    <div><input id="password" type="password" class="uk-input form-control @error('password') is-invalid @enderror" name="password" required autocomplete="on"></div>
                </div>
                @error('password')
                    <div class="uk-alert-warning" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p>{{ $message }}</p>
                    </div>
                @enderror
            </div>
            <div class="other__content__login">
                <div class="other__content__login__inner">
                    <label>確認用パスワード</label>
                    <div><input id="password_confirmation" type="password" class="uk-input form-control" name="password_confirmation" required autocomplete="new-password"></div>
                </div>
            </div>
            <div class="other__content__login">
                <div class="other__content__login__inner">
                    <label>電話番号</label>
                    <div><input id="phone_number" type="text" class="uk-input form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="on" autofocus></div>
                </div>
                @error('phone_number')
                    <div class="uk-alert-warning" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p>{{ $message }}</p>
                    </div>
                @enderror
            </div>
            <div class="other__content__login l-flex">
                <div class="u-w49per">
                    <div class="other__content__login__inner">
                        <label>姓</label>
                        <div><input id="last_name" type="text" class="uk-input form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="on" autofocus></div>
                    </div>
                    @error('last_name')
                        <div class="uk-alert-warning" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p>{{ $message }}</p>
                        </div>
                    @enderror
                </div>
                <div class="u-w49per">
                    <div class="other__content__login__inner">
                        <label>名</label>
                        <div><input id="first_name" type="text" class="uk-input form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="on" autofocus></div>
                    </div>
                    @error('first_name')
                        <div class="uk-alert-warning" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p>{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>
            <div class="other__content__login l-flex">
                <div class="u-w49per">
                    <div class="other__content__login__inner">
                        <label>セイ</label>
                        <div><input id="last_name_kana" type="text" class="uk-input form-control @error('last_name_kana') is-invalid @enderror" name="last_name_kana" value="{{ old('last_name_kana') }}" required autocomplete="on" autofocus></div>
                    </div>
                    @error('last_name_kana')
                        <div class="uk-alert-warning" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p>{{ $message }}</p>
                        </div>
                    @enderror
                </div>
                <div class="u-w49per">
                    <div class="other__content__login__inner">
                        <label>ナ</label>
                        <div><input id="first_name_kana" type="text" class="uk-input form-control @error('first_name_kana') is-invalid @enderror" name="first_name_kana" value="{{ old('first_name_kana') }}" required autocomplete="on" autofocus></div>
                    </div>
                    @error('first_name_kana')
                        <div class="uk-alert-warning" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p>{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>
            <div class="other__content__login">
                <div class="other__content__login__inner">
                    <label>郵便番号</label>
                    <div><input id="postcode" type="text" class="uk-input form-control @error('postcode') is-invalid @enderror" name="postcode" value="{{ old('postcode') }}" required autocomplete="on" autofocus></div>
                </div>
                @error('postcode')
                    <div class="uk-alert-warning" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p>{{ $message }}</p>
                    </div>
                @enderror
            </div>
            <div class="other__content__login">
                <div class="other__content__login__inner">
                    <label>住所1</label>
                    <div><input id="city" type="text" class="uk-input form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="on" autofocus></div>
                </div>
                @error('city')
                    <div class="uk-alert-warning" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p>{{ $message }}</p>
                    </div>
                @enderror
            </div>
            <div class="other__content__login">
                <div class="other__content__login__inner">
                    <label>住所2</label>
                    <div><input id="block" type="text" class="uk-input form-control @error('block') is-invalid @enderror" name="block" value="{{ old('block') }}" required autocomplete="on" autofocus></div>
                </div>
                @error('block')
                    <div class="uk-alert-warning" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p>{{ $message }}</p>
                    </div>
                @enderror
            </div>
            <div class="other__content__login">
                <div class="other__content__login__inner">
                    <button type="submit" class="btn btn-primary">登録</button>
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
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
--}}