@extends('layouts.page')

<!-- タイトル・メタディスクリプション -->
@section('title', '会社概要 | モアクロ')
@section('description', '会社概要')

<!-- CSS -->
@push('css')
<link rel="stylesheet" href="{{ asset('css/page/other.css') }}">
@endpush

<!-- 本文 -->
@section('content')
<section class="other__screen">
    <div class="l-wrap">
        <h1>会社概要</h1>
    </div>
</section>
<section class="other__content page__other">
    <div class="l-wrap">
        <article class="uk-article">
            <table class="uk-table uk-table-responsive uk-table-divider">
                <tbody>
                    <tr>
                        <th style="vertical-align: middle;">商号</th>
                        <td>株式会社K-WEST</td>
                    </tr>
                    <tr>
                        <th style="vertical-align: middle;">本社所在地</th>
                        <td>〒617-0002<br>京都府向日市寺戸町向畑５２番地５イーグルハウスビル３階</td>
                    </tr>
                </tbody>
            </table>
        </article>
    </div>
</section>
@endsection
