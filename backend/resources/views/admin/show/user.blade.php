@extends('layouts.admin')

<!-- タイトル・メタディスクリプション -->
@section('title', 'ユーザー詳細 | モアクロ')
@section('description', 'ユーザー詳細')

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
    <div id="modal-stop" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">一時停止</h2>
            </div>
            <form method="POST" action="{{ route('admin.edit.user.stop') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="uk-modal-footer uk-text-right">
                    <button class="c-button c-button--default uk-modal-close u-mr10" type="button">キャンセル</button>
                    <button class="c-button c-button--bgPink" type="submit">一時停止</button>
                </div>
            </form>
        </div>
    </div>
    {{--  モーダル 完全削除  --}}
    {{--  <div id="modal-delete" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">完全削除手続き</h2>
            </div>
            <form method="POST" action="{{ route('admin.edit.user.delete') }}">
                @csrf
                <input id="reject_id" name="reject_id" type="hidden" value="{{ $user->id }}">
                <div class="uk-modal-body">
                    <div class="uk-modal-footer uk-text-right">
                        <button class="c-button c-button--default uk-modal-close u-mr10" type="button">キャンセル</button>
                        <button class="c-button c-button--bgPink" type="submit">非承認決定</button>
                    </div>
                </div>
            </form>
        </div>
    </div>  --}}

    <div class="admin-header">
        <h1>ユーザー詳細</h1>
    </div>
    <div class="admin-body">
        <table class="uk-table uk-table-responsive uk-table-divider">
            <tbody>
                <tr>
                    <td colspan="2">
                        <button class="c-button c-button--pink u-mr10" type="button" uk-toggle="target: #modal-stop">削除</button>
                        {{--  <button class="c-button c-button--bgPink" type="button" uk-toggle="target: #modal-delete">完全削除</button>  --}}
                    </td>
                </tr>
                <tr>
                    <th>ID</th>
                    <td>{{ $user->id }}</td>
                </tr>
                {{--  <tr>
                    <th>ステータス</th>
                    <td>
                        @if($user->deleted_at == null) 活動中
                        @else 一時停止中
                        @endif
                    </td>
                </tr>  --}}
                <tr>
                    <th style="width: 200px;">苗字（かな）</th>
                    <td>{{ $user->last_name }}（{{ $user->last_name_kana }}）</td>
                </tr>
                <tr>
                    <th>名前（かな）</th>
                    <td>{{ $user->first_name }}（{{ $user->first_name_kana }}）</td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td>{{ $user->phone_number }}</td>
                </tr>
                <tr>
                    <th>郵便番号</th>
                    <td>{{ $user->postcode }}</td>
                </tr>
                <tr>
                    <th>住所1</th>
                    <td>{{ $user->city }}</td>
                </tr>
                <tr>
                    <th>住所2</th>
                    <td>{{ $user->block }}</td>
                </tr>
                <tr>
                    <th>メモ</th>
                    <td>{{ $user->memo }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
