@extends('layouts.admin')

<!-- タイトル・メタディスクリプション -->
@section('title', '担当者を追加 | モアクロ')
@section('description', '担当者を追加')

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
        <h1>担当者を追加</h1>
    </div>
    <div class="admin-body">
        <form method="POST" action="{{ route('admin.add.staff.post') }}">
        @csrf
            <input type="hidden" name="manager_id" value="{{ $managerId }}">
            <table style="width: auto;" class="uk-table uk-table-responsive uk-table-divider">
                <tbody>
                    <tr>
                        <th style="width: 150px; vertical-align: middle;">支店</th>
                        <td style="width: 400px;">
                            <div class="user__content__box__gray u-p0">
                                <select name="shop" class="uk-select user__content__box__gray__inner" id="form-horizontal-select">
                                    @foreach($shops as $shop)
                                    <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150px; vertical-align: middle;">姓</th>
                        <td style="width: 400px;">
                            <div class="user__content__box__gray u-p0">
                                <input type="text" name="name1" class="uk-input user__content__box__gray__inner" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150px; vertical-align: middle;">名</th>
                        <td style="width: 400px;">
                            <div class="user__content__box__gray u-p0">
                                <input type="text" name="name2" class="uk-input user__content__box__gray__inner" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150px; vertical-align: middle;">メールアドレス</th>
                        <td style="width: 400px;">
                            <div class="user__content__box__gray u-p0">
                                <input type="text" name="email" class="uk-input user__content__box__gray__inner" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150px; vertical-align: middle;">メモ</th>
                        <td style="width: 400px;">
                            <div class="user__content__box__gray u-p0">
                                <textarea name="memo" class="uk-input user__content__box__gray__inner"></textarea>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="2"><button class="c-button c-button--bgBlue" type="submit">担当者を追加する</button></th>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection
