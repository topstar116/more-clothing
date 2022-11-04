@extends('layouts.admin')

<!-- タイトル・メタディスクリプション -->
@section('title', 'レンタルユーザー一覧 | モアクロ')
@section('description', 'レンタルユーザー一覧')

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

    {{--  モーダル レンタルユーザー 削除  --}}
    <div id="modal-delete" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">削除手続き</h2>
            </div>
            <form method="POST" action="{{ route('admin.edit.rental.user.stop') }}" enctype="multipart/form-data">
                @csrf
                <input id="target_id" name="target_id" type="hidden" value="">
                <div class="uk-modal-footer uk-text-right">
                    <button class="c-button c-button--default uk-modal-close u-mr10" type="button">キャンセル</button>
                    <button class="c-button c-button--bgPink" type="submit">削除する</button>
                </div>
            </form>
        </div>
    </div>
    {{--  モーダル 非承認  --}}
    {{-- <div id="modal-no" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">非承認手続き</h2>
            </div>
            <form method="POST" action="{{ route('admin.request.rental.reject') }}">
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
    </div> --}}

    <div class="admin-header">
        <h1>レンタルユーザー一覧</h1>
    </div>
    <div class="admin-body">
        <table class="uk-table uk-table-middle uk-table-responsive uk-table-divider">
            <thead>
                <tr>
                    <th>ユーザー名</th>
                    <th>電話番号</th>
                    <th>メールアドレス</th>
                    <th>メモ</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($rentalUsers as $user)
                <tr>
                    <td><a class="u-text--link" href="{{ route('admin.show.rental.user', $user->id) }}">{{ $user->name1 }} {{ $user->name2 }}<br>{{ $user->kana1 }} {{ $user->kana2 }}</a></td>
                    <td>{{ $user->tel }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->memo }}</td>
                    <td style="white-space: nowrap">
                        <button class="c-button c-button--bgPink u-mr10" type="button" uk-toggle="target: #modal-delete" onclick="event.preventDefault();document.getElementById('target_id').value = {{ $user->id }}">削除</button>
                        {{--  <button class="c-button c-button--bgPink" type="button" uk-toggle="target: #modal-no" onclick="event.preventDefault();document.getElementById('reject_id').value = {{ $user->id }}">削除</button>  --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
