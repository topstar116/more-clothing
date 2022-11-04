@extends('layouts.page')

<!-- タイトル・メタディスクリプション -->
@section('title', 'FAQ | モアクロ')
@section('description', 'FAQ')

<!-- CSS -->
@push('css')
<link rel="stylesheet" href="{{ asset('css/page/other.css') }}">
@endpush

<!-- 本文 -->
@section('content')
<section class="other__screen">
    <div class="l-wrap">
        <h1>FAQ</h1>
    </div>
</section>
<section class="other__content page__other">
    <div class="l-wrap">
    </div>
</section>
@endsection
