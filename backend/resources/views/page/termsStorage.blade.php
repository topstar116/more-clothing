@extends('layouts.page')

<!-- タイトル・メタディスクリプション -->
@section('title', '保管サービス利用規約 | モアクロ')
@section('description', '保管サービス利用規約')

<!-- CSS -->
@push('css')
<link rel="stylesheet" href="{{ asset('css/page/other.css') }}">
@endpush

<!-- 本文 -->
@section('content')
<section class="other__screen">
    <div class="l-wrap">
        <h1>保管サービス利用規約</h1>
    </div>
</section>
<section class="other__content page__other">
    <div class="l-wrap">
        <article class="uk-article">
            <p>株式会社more clothing（以下「当社」といいます）当社が運営管理するＷebサイト「more clothing」（以下「当サイト」といい、当サイトで提供されるサービスを「本サービス」といいます）において、利用規約（以下「Web規約」といいます）を、以下のとおり定めます。</p>
            <h2>第１条（規約の適用）</h2>
            <div class="uk-child-width-expand@s" uk-grid>
                <ul class="uk-list uk-list-decimal">
                    <li>List item 1List item 1List item 1List item 1List item 1List item 1List item 1List item 1</li>
                    <li>List item 2</li>
                    <li>List item 3</li>
                </ul>
            </div>
        </article>
    </div>
</section>
@endsection
