@extends('layouts.admin')

<!-- タイトル・メタディスクリプション -->
@section('title', '支店一覧 | モアクロ')
@section('description', '支店一覧')

<!-- CSS -->
@push('css')
@endpush

<!-- 本文 -->
@section('content')
    @if(session('success-message'))
    <section class="user__content">
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <div class="uk-alert-success u-mb0" uk-alert>
                        {{ session('success-message') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{--  エラーメッセージ  --}}
    @if ($errors->any())
    <section class="user__content">
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <div class="uk-alert-danger u-mb0" uk-alert>
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

    {{--  モーダル 削除  --}}
    <div id="modal-delete" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">支店を削除</h2>
            </div>
            <form method="POST" action="{{ route('admin.edit.shop.stop') }}">
                @csrf
                <input id="target_id" name="target_id" type="hidden" value="">
                <div class="uk-modal-footer uk-text-right">
                    <button class="c-button c-button--default uk-modal-close u-mr10" type="button">キャンセル</button>
                    <button class="c-button c-button--bgPink" type="submit">削除する</button>
                </div>
            </form>
        </div>
    </div>

    <div class="admin-header">
        <h1>支店一覧</h1>
    </div>
    <div class="admin-body">
        <table class="uk-table uk-table-responsive uk-table-divider uk-table-middle">
            <thead>
                <tr>
                    <th>登録日</th>
                    <th>支店名</th>
                    <th>メールアドレス</th>
                    <th>郵便番号<br>住所</th>
                    <th>電話番号</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($shops as $shop)
                <tr>
                    <td>{{ $shop->created_at }}</td>
                    <td>{{ $shop->name }}</td>
                    <td>{{ $shop->email }}</td>
                    <td>{{ $shop->postcode }}<br>{{ $shop->city }} {{ $shop->block }}</td>
                    <td>{{ $shop->phone_number }}</td>
                    <td style="white-space: nowrap">
                        <button class="c-button c-button--bgPink" type="button" uk-toggle="target: #modal-delete" onclick="event.preventDefault();document.getElementById('target_id').value = {{ $shop->id }}">削除</button>
                    </td>
                </tr>
                @endforeach
                {{--  <tr>
                    <td>2020.01.01</td>
                    <td>清水 聖子</td>
                    <td><a href="">荷物ID</a></td>
                    <td>500円</td>
                    <td>サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル</td>
                    <td style="white-space: nowrap">
                        <button class="c-button c-button--blue u-mr10" type="button" uk-toggle="target: #modal-ok">承認</button>
                        <button class="c-button c-button--pink" type="button" uk-toggle="target: #modal-no">非承認</button>
                    </td>
                </tr>
                <tr>
                    <td>2020.01.01</td>
                    <td>清水 聖子</td>
                    <td><a href="">荷物ID</a></td>
                    <td>500円</td>
                    <td>サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル</td>
                    <td style="white-space: nowrap">
                        <button class="c-button c-button--blue u-mr10" type="button" uk-toggle="target: #modal-ok">承認</button>
                        <button class="c-button c-button--pink" type="button" uk-toggle="target: #modal-no">非承認</button>
                    </td>
                </tr>
                <tr>
                    <td>2020.01.01</td>
                    <td>清水 聖子</td>
                    <td><a href="">荷物ID</a></td>
                    <td>500円</td>
                    <td>サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル</td>
                    <td style="white-space: nowrap">
                        <button class="c-button c-button--blue u-mr10" type="button" uk-toggle="target: #modal-ok">承認</button>
                        <button class="c-button c-button--pink" type="button" uk-toggle="target: #modal-no">非承認</button>
                    </td>
                </tr>  --}}
            </tbody>
        </table>
    </div>
@endsection
