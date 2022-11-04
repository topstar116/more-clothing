@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', '寄付手続き 完了 | モアクロ')
@section('description', '寄付手続き 完了')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="寄付手続き 完了"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>
<section class="user__content">
    <div class="user__content__headline">
        <div class="user__content__headline__inner complete-message">
            <p class="message">COMPLETE！</p>
            <p>寄付していただき、<br>誠に有難うございます！</p>
        </div>
    </div>
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__info u-textAlign__center">
                <a class="u-text--link" href="{{ route('custody.box') }}">保管荷物一覧へ</a>
            </div>
        </div>
    </div>
</section>
@endsection
