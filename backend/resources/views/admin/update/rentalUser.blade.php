@extends('layouts.admin')

<!-- タイトル・メタディスクリプション -->
@section('title', 'レンタルユーザー編集 | モアクロ')
@section('description', 'レンタルユーザー編集')

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
        <h1>レンタルユーザーを編集する</h1>
    </div>
    <div class="admin-body">
        <form method="POST" action="{{ route('admin.edit.rental.user.store') }}">
        @csrf
            <input type="hidden" name="manager_id" value="{{ $managerId }}">
            <input type="hidden" name="id" value="{{ $rentalUser->id }}">
            <table style="width: auto;" class="uk-table uk-table-responsive uk-table-divider">
                <tbody>
                    <tr>
                        <th style="width: 150px; vertical-align: middle;">苗字</th>
                        <td style="width: 400px;">
                            <div class="user__content__box__gray u-p0">
                                <input type="text" name="name1" class="uk-input user__content__box__gray__inner" value="{{ $rentalUser->name1 }}">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150px; vertical-align: middle;">名前</th>
                        <td style="width: 400px;">
                            <div class="user__content__box__gray u-p0">
                                <input type="text" name="name2" class="uk-input user__content__box__gray__inner" value="{{ $rentalUser->name2 }}">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150px; vertical-align: middle;">苗字（カナ）</th>
                        <td style="width: 400px;">
                            <div class="user__content__box__gray u-p0">
                                <input type="text" name="kana1" class="uk-input user__content__box__gray__inner" value="{{ $rentalUser->kana1 }}">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150px; vertical-align: middle;">名前（カナ）</th>
                        <td style="width: 400px;">
                            <div class="user__content__box__gray u-p0">
                                <input type="text" name="kana2" class="uk-input user__content__box__gray__inner" value="{{ $rentalUser->kana2 }}">
                            </div>
                        </td>
                    </tr>
                    {{-- <tr>
                        <th style="width: 150px; vertical-align: middle;">パスワード<br><span class="u-text--small">強制的に上書きされます。</span></th>
                        <td style="width: 400px;">
                            <div class="user__content__box__gray u-p0">
                                <input type="text" name="password" class="uk-input user__content__box__gray__inner">
                            </div>
                        </td>
                    </tr> --}}
                    <tr>
                        <th style="width: 150px; vertical-align: middle;">メールアドレス</th>
                        <td style="width: 400px;">
                            <div class="user__content__box__gray u-p0">
                                <input type="text" name="email" class="uk-input user__content__box__gray__inner" value="{{ $rentalUser->email }}">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150px; vertical-align: middle;">電話番号</th>
                        <td style="width: 400px;">
                            <div class="user__content__box__gray u-p0">
                                <input type="text" name="tel" class="uk-input user__content__box__gray__inner" value="{{ $rentalUser->tel }}">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150px; vertical-align: middle;">郵便番号</th>
                        <td style="width: 400px;">
                            <div class="user__content__box__gray u-p0">
                                <input type="text" name="post" class="uk-input user__content__box__gray__inner" value="{{ $rentalUser->post }}">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150px; vertical-align: middle;">住所1</th>
                        <td style="width: 400px;">
                            <div class="user__content__box__gray u-p0">
                                <input type="text" name="address1" class="uk-input user__content__box__gray__inner" value="{{ $rentalUser->address1 }}">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150px; vertical-align: middle;">住所2</th>
                        <td style="width: 400px;">
                            <div class="user__content__box__gray u-p0">
                                <input type="text" name="address2" class="uk-input user__content__box__gray__inner" value="{{ $rentalUser->address2 }}">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150px; vertical-align: middle;">メモ</th>
                        <td style="width: 400px;">
                            <div class="user__content__box__gray u-p0">
                                <textarea name="memo" class="uk-input user__content__box__gray__inner" value="{{ $rentalUser->memo }}"></textarea>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="2"><button class="c-button c-button--bgBlue" type="submit">レンタルユーザー情報を更新する</button></th>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection
