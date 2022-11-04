@extends('layouts.admin')

<!-- タイトル・メタディスクリプション -->
@section('title', '販売代行停止リクエスト一覧 | モアクロ')
@section('description', '販売代行停止リクエスト一覧')

<!-- CSS -->
@push('css')
@endpush

<!-- 本文 -->
@section('content')
    {{--  サクセスメッセージ  --}}
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

    {{--  モーダル 承認  --}}
    <div id="modal-ok" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">承認手続き</h2>
            </div>
            <form method="POST" action="{{ route('admin.stop.request.sales.post') }}">
                @csrf
                <input id="target_id" name="target_id" type="hidden" value="">
                <div class="uk-modal-body">
                    <div class="user__content__box__gray">
                        <p class="sub-headline">担当者名前</p>
                        <select name="staff" class="uk-select user__content__box__gray__inner" id="form-horizontal-select">
                            @foreach($staffs as $staff)
                            <option value="{{ $staff->id }}">{{ $staff->name1 }} {{ $staff->name2 }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">メモ</p>
                        <textarea name="memo" class="uk-input user__content__box__gray__inner"></textarea>
                    </div>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button class="c-button c-button--default uk-modal-close u-mr10" type="button">キャンセル</button>
                    <button class="c-button c-button--bgBlue" type="submit">承認決定</button>
                </div>
            </form>
        </div>
    </div>
    {{--  モーダル 非承認  --}}
    <div id="modal-no" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">非承認手続き</h2>
            </div>
            <form method="POST" action="{{ route('admin.stop.request.sales.reject') }}">
                @csrf
                <input id="reject_id" name="reject_id" type="hidden" value="">
                <div class="uk-modal-body">
                    <div class="user__content__box__gray">
                        <p class="sub-headline">担当者名前</p>
                        <select name="staff" class="uk-select user__content__box__gray__inner" id="form-horizontal-select">
                            @foreach($staffs as $staff)
                            <option value="{{ $staff->id }}">{{ $staff->name1 }} {{ $staff->name2 }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">非承認理由</p>
                        <textarea name="reason" class="uk-input user__content__box__gray__inner"></textarea>
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">メモ</p>
                        <textarea name="memo" class="uk-input user__content__box__gray__inner"></textarea>
                    </div>
                    <div class="uk-modal-footer uk-text-right">
                        <button class="c-button c-button--default uk-modal-close u-mr10" type="button">キャンセル</button>
                        <button class="c-button c-button--bgPink" type="submit">非承認決定</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="admin-header">
        <h1>販売代行停止リクエスト一覧</h1>
    </div>
    <div class="admin-body">
        <table class="uk-table uk-table-responsive uk-table-divider">
            <thead>
                <tr>
                    <th style="white-space: nowrap">依頼日</th>
                    <th style="white-space: nowrap">依頼者</th>
                    <th style="white-space: nowrap">荷物ID</th>
                    <th style="white-space: nowrap">その他リクエスト</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($itemRequests as $itemRequest)
                <tr>
                    <td>{{ $itemRequest->created_at }}</td>
                    <td><a class="u-text--link" href="">{{ $itemRequest->user_name1 }} {{ $itemRequest->user_name2 }}</td>
                    <td><a class="u-text--link" href="">{{ $itemRequest->item_number }}</td>
                    <td>{{ $itemRequest->memo }}</td>
                    <td style="white-space: nowrap">
                        <button class="c-button c-button--blue u-mr10" type="button" uk-toggle="target: #modal-ok" onclick="event.preventDefault();document.getElementById('target_id').value = {{ $itemRequest->id }}">承認</button>
                        <button class="c-button c-button--pink" type="button" uk-toggle="target: #modal-no" onclick="event.preventDefault();document.getElementById('reject_id').value = {{ $itemRequest->id }}">非承認</button>
                    </td>
                </tr>
                @endforeach
                {{--  <tr>
                    <td>2020.01.01</td>
                    <td>清水 聖子</td>
                    <td><a href="">荷物ID</a></td>
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
