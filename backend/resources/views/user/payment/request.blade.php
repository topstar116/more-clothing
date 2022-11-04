@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', '出金リクエスト | モアクロ')
@section('description', '出金リクエスト')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="出金リクエスト"
    back="/custody/trade-history/"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>

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
<form method="POST" action="{{ route('custody.payment.request.post') }}">
    @csrf
    {{-- {{ Session::getOldInput() }} --}}
    <how-withdrawal-component
        :points={{ json_encode($points) }}
        :sessionparams="{{ json_encode($sessionInfo) }}"
    ></how-withdrawal-component>
    <request-payment-component
        :sessionparams="{{ json_encode($sessionInfo) }}"
    ></request-payment-component>
</form>
@endsection
