@extends('layouts.admin')

<!-- タイトル・メタディスクリプション -->
@section('title', '販売中商品一覧 | モアクロ')
@section('description', '販売中商品一覧')

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

    {{--  モーダル：販売完了 --}}
    <div id="modal-sell" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">売却完了報告</h2>
            </div>
            <form method="POST" action="{{ route('admin.edit.item.sold') }}">
                @csrf
                <input id="sell_id" name="sell_id" type="hidden" value="">
                <div class="uk-modal-body">
                    <div class="user__content__box__gray">
                        <p class="sub-headline">担当者名前</p>
                        <select name="staff_id" class="uk-select user__content__box__gray__inner" id="form-horizontal-select">
                            @foreach($staffs as $staff)
                            <option value="{{ $staff->id }}">{{ $staff->last_name }} {{ $staff->first_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">売却日</p>
                        <vue-datapicker-now-component></vue-datapicker-now-component>
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">売却価格</p>
                        <input name="price" class="uk-input user__content__box__gray__inner">
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">売却手数料</p>
                        <input name="fee" class="uk-input user__content__box__gray__inner">
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">送料</p>
                        <input name="shipping" class="uk-input user__content__box__gray__inner">
                    </div>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button class="c-button c-button--default uk-modal-close u-mr10" type="button">キャンセル</button>
                    <button class="c-button c-button--bgPink" type="submit">報告する</button>
                </div>
            </form>
        </div>
    </div>

    {{--  モーダル：販売停止  --}}
    <div id="modal-stop" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">販売代行停止</h2>
            </div>
            <form method="POST" action="{{ route('admin.edit.item.sell.stop') }}">
                @csrf
                <input id="stop_id" name="stop_id" type="hidden" value="">
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
                    <button class="c-button c-button--bgBlue" type="submit">販売停止する</button>
                </div>
            </form>
        </div>
    </div>

    <div class="admin-header">
        <h1>販売中商品一覧</h1>
    </div>
    <div class="admin-body">
        <table class="uk-table uk-table-middle uk-table-responsive uk-table-divider">
            <thead>
                <tr>
                    <th>登録日</th>
                    <th>番号</th>
                    <th>支店<br>担当者</th>
                    <th>サムネイル</th>
                    <th>預入方法</th>
                    <th>販売価格</th>
                    <th>販売URL</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($sellItems as $sellItem)
                    <tr>
                        <td>{{ $sellItem->created_at }}</td>
                        <td><a href="">{{ $sellItem->number }}</a></td>
                        <td>{{ $sellItem->shop_name }}<br>{{ $sellItem->staff_name1 }} {{ $sellItem->staff_name2 }}</td>
                        <td>
                            <div class="item__img u-w80">
                                <div class="item__img__inner">
                                    <img src="{{ $sellItem->url }}">
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($sellItem->how == 0)箱
                            @elseif($sellItem->how == 1)ハンガー
                            @endif
                        </td>
                        <td>¥{{ number_format($sellItem->selling_price) }}</td>
                        <td><a href="{{ $sellItem->selling_url }}" rel="nofollow noopener noreferrer" target="_blank">{{ $sellItem->selling_url }}</td>
                        <td>
                            <button class="c-button c-button--blue u-mr10" type="button" uk-toggle="target: #modal-sell" onclick="event.preventDefault();document.getElementById('sell_id').value = {{ $sellItem->sell_id }}">販売完了</button>
                            <button class="c-button c-button--pink" type="button" uk-toggle="target: #modal-stop" onclick="event.preventDefault();document.getElementById('stop_id').value = {{ $sellItem->sell_id }}">販売停止</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
