@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', '退会希望 | モアクロ')
@section('description', '退会希望')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="退会希望"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>
<section class="user__content">
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__info">
                <p class="u-mb0">退会希望者は、運営者にお問い合わせください。</p>
            </div>
            <div class="user__content__box__info">
                <p class="u-mb0">１．運営者に連絡<br>info@more-clothing.site</p>
            </div>
        </div>
    </div>
</section>
@endsection
