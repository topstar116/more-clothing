@extends('layouts.admin')

<!-- タイトル・メタディスクリプション -->
@section('title', '保管箱一覧 | モアクロ')
@section('description', '保管箱一覧')

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
                <h2 class="uk-modal-title">箱を削除</h2>
            </div>
            <form method="POST" action="{{ route('admin.edit.box.stop') }}" enctype="multipart/form-data">
                @csrf
                <input id="delete_id" name="delete_id" type="hidden" value="">
                <div class="uk-modal-footer uk-text-right">
                    <button class="c-button c-button--default uk-modal-close u-mr10" type="button">キャンセル</button>
                    <button class="c-button c-button--bgPink" type="submit">削除する</button>
                </div>
            </form>
        </div>
    </div>

    <div class="admin-header">
        <h1>保管箱一覧</h1>
    </div>
    <div class="admin-body">
        <table class="uk-table uk-table-responsive uk-table-divider uk-table-middle">
            <thead>
                <tr>
                    {{-- <th>箱受取日<br>箱登録日</th> --}}
                    <th>箱受取日</th>
                    <th>箱番号</th>
                    <th>ユーザー名</th>
                    <th>メモ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($boxes as $box)
                <tr>
                    {{-- <td>{{ $box->received_at }}<br>{{ $box->created_at }}</td> --}}
                    <td>{{ $box->received_on }}</td>
                    <td><a href="{{ route('admin.show.box', $box->id) }}">{{ $box->number }}</a></td>
                    <td style="white-space: nowrap"><a class="u-text--link" href="{{ route('admin.show.user', $box->user_id) }}">{{ $box->user_name1 }} {{ $box->user_name2 }}<br>{{ $box->user_kana1 }} {{ $box->user_kana2 }}</a></td>
                    <td>{{ $box->detail }}</td>
                    <td style="white-space: nowrap">
                        <button class="c-button c-button--bgPink u-mr10" type="button" uk-toggle="target: #modal-delete" onclick="event.preventDefault();document.getElementById('delete_id').value = {{ $box->id }}">削除</button>
                        {{--  <button class="c-button c-button--bgPink" type="button" uk-toggle="target: #modal-no" onclick="event.preventDefault();document.getElementById('reject_id').value = {{ $user->id }}">削除</button>  --}}
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
