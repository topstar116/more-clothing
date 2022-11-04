@extends('layouts.admin')

<!-- タイトル・メタディスクリプション -->
@section('title', '箱を追加 | モアクロ')
@section('description', '箱を追加')

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

    <div class="admin-header">
        <h1>箱を追加</h1>
    </div>
    <div class="admin-body">
        <form method="POST" action="{{ route('admin.add.box.post') }}">
        @csrf
            <table style="width: auto;" class="uk-table uk-table-responsive uk-table-divider">
                <tbody>
                    <tr>
                        <th style="width: 150px; vertical-align: middle;">該当ユーザー</th>
                        <td style="width: 400px;">
                            <div class="user__content__box__gray u-p0">
                                <select name="user" class="uk-select user__content__box__gray__inner" id="form-horizontal-select" required>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->last_name }} {{ $user->first_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150px; vertical-align: middle;">担当者</th>
                        <td style="width: 400px;">
                            <div class="user__content__box__gray u-p0">
                                <select name="staff" class="uk-select user__content__box__gray__inner" id="form-horizontal-select" required>
                                    @foreach($staffs as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->last_name }} {{ $staff->first_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150px; vertical-align: middle;">預かり日</th>
                        <td style="width: 400px;"><vue-datapicker-now-component></vue-datapicker-now-component></td>
                    </tr>
                    <tr>
                        <th style="width: 150px; vertical-align: middle;">詳細</th>
                        <td style="width: 400px;">
                            <div class="user__content__box__gray u-p0">
                                <textarea name="detail" class="uk-input user__content__box__gray__inner"></textarea>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="2"><button class="c-button c-button--bgBlue" type="submit">箱を追加する</button></th>
                    </tr>
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
        </form>
    </div>
@endsection
