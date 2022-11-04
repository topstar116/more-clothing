@extends('layouts.admin')

<!-- タイトル・メタディスクリプション -->
@section('title', '出金リクエスト一覧 | モアクロ')
@section('description', '出金リクエスト一覧')

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
            <form method="POST" action="{{ route('admin.request.withdrawal.post') }}">
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
                        <p class="sub-headline">その他メモ</p>
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
            <form method="POST" action="{{ route('admin.request.withdrawal.reject') }}">
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
                        <p class="sub-headline">社内メモ</p>
                        <textarea name="memo" class="uk-input user__content__box__gray__inner"></textarea>
                    </div>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button class="c-button c-button--default uk-modal-close u-mr10" type="button">キャンセル</button>
                    <button class="c-button c-button--bgPink" type="submit">非承認決定</button>
                </div>
            </form>
        </div>
    </div>

    <div class="admin-header">
        <h1>出金リクエスト一覧</h1>
    </div>
    <div class="admin-body">
        <table class="uk-table uk-table-responsive uk-table-divider">
            <thead>
                <tr>
                    <th style="white-space: nowrap">依頼日</th>
                    <th style="white-space: nowrap">依頼者</th>
                    <th style="white-space: nowrap">出金希望金額</th>
                    <th style="white-space: nowrap">手数料</th>
                    <th style="white-space: nowrap">振込金額</th>
                    <th style="white-space: nowrap">その他リクエスト</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($withdrawals as $index => $withdrawal)
                <tr>
                    <td>{{ $withdrawal->created_at }}</td>
                    <td><a class="u-text--link" href="">{{ $withdrawal->user_name1 }} {{ $withdrawal->user_name2 }}</a></td>
                    <td>{{ number_format($withdrawal->price) }}円</td>
                    <td>{{ number_format($withdrawal->fee) }}円</td>
                    <td>{{ number_format($withdrawal->transfer) }}円</td>
                    <td>{{ $withdrawal->memo }}</td>
                    <td style="white-space: nowrap">
                        <button class="c-button c-button--blue u-mr10" type="button" uk-toggle="target: #modal-ok" onclick="event.preventDefault();document.getElementById('target_id').value = {{ $withdrawal->id }}">承認</button>
                        <button class="c-button c-button--pink" type="button" uk-toggle="target: #modal-no" onclick="event.preventDefault();document.getElementById('reject_id').value = {{ $withdrawal->id }}">非承認</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
