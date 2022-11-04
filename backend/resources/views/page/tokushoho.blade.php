@extends('layouts.page')

<!-- タイトル・メタディスクリプション -->
@section('title', '特定商取引法 | モアクロ')
@section('description', '特定商取引法')

<!-- CSS -->
@push('css')
<link rel="stylesheet" href="{{ asset('css/page/other.css') }}">
@endpush

<!-- 本文 -->
@section('content')
<section class="other__screen">
    <div class="l-wrap">
        <h1>特定商取引法</h1>
    </div>
</section>
<section class="other__content page__other">
    <div class="l-wrap">
    </div>
</section>
@endsection
