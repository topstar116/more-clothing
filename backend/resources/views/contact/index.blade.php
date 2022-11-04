@extends('layouts.page')

<!-- タイトル・メタディスクリプション -->
@section('title', 'お問い合わせ | モアクロ')
@section('description', 'お問い合わせ')

<!-- CSS -->
@push('css')
<link rel="stylesheet" href="{{ asset('css/page/other.css') }}">
@endpush

<!-- 本文 -->
@section('content')
<section class="other__screen">
    <div class="l-wrap">
        <h1>お問い合わせ</h1>
    </div>
</section>
<section class="other__content page__other">
    <div class="l-wrap">
        <article class="uk-article">
        </article>
    </div>
</section>
@endsection
