@extends('layouts.admin')

<!-- タイトル・メタディスクリプション -->
@section('title', '箱詳細 | モアクロ')
@section('description', '箱詳細')

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

    {{--  モーダル 荷物追加  --}}
    <div id="modal-add" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">荷物追加</h2>
            </div>
            <form method="POST" action="{{ route('admin.add.item.post') }}" enctype="multipart/form-data">
                @csrf
                <input id="add_id" name="add_id" type="hidden" value="">
                <div class="uk-modal-body">
                    <div class="user__content__box__gray">
                        <p class="sub-headline">担当支店</p>
                        <select name="shop_id" class="uk-select user__content__box__gray__inner" id="form-horizontal-select">
                            <option value="{{ $box->staff->shop->id }}">{{ $box->staff->shop->name }}</option>
                        </select>
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">荷物詳細</p>
                        <textarea name="item_detail" class="uk-input user__content__box__gray__inner"></textarea>
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">保管方法</p>
                        <select name="how" class="uk-select user__content__box__gray__inner" id="form-horizontal-select">
                            <option value="0">箱</option>
                            <option value="1">ハンガー</option>
                        </select>
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">荷物画像（最大5枚）</p>
                        <image-upload-component></image-upload-component>
                    </div>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button class="c-button c-button--default uk-modal-close u-mr10" type="button">キャンセル</button>
                    <button class="c-button c-button--bgBlue" type="submit">荷物を追加</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-delete" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">箱削除</h2>
            </div>
            <form method="POST" action="{{ route('admin.edit.box.stop') }}">
                @csrf
                <input id="delete_id" name="delete_id" type="hidden" value="">
                <div class="uk-modal-footer uk-text-right">
                    <button class="c-button c-button--default uk-modal-close u-mr10" type="button">キャンセル</button>
                    <button class="c-button c-button--bgPink" type="submit">削除する</button>
                </div>
            </form>
        </div>
    </div>
    {{--  モーダル 箱削除  --}}
    <div id="modal-sold" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">箱削除</h2>
            </div>
            <form method="POST" action="{{ route('admin.edit.item.sold') }}" enctype="multipart/form-data">
                @csrf
                <input id="sell_id" name="sell_id" type="hidden" value="">
                <div class="uk-modal-body">
                    <div class="user__content__box__gray">
                        <p class="sub-headline">担当者名前</p>
                        <select name="staff_id" class="uk-select user__content__box__gray__inner" id="form-horizontal-select">
                            <option value="{{ $box->staff->id }}">{{ $box->staff->last_name }} {{ $box->staff->first_name }}</option>
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


    <div class="admin-header">
        <h1>箱詳細</h1>
    </div>
    <div class="admin-body">
        @if (!empty($box))
        <table class="uk-table uk-table-responsive uk-table-divider">
            <tbody>
                <tr>
                    <td colspan="2">
                        <button class="c-button c-button--bgBlue u-mr10" type="button" uk-toggle="target: #modal-add" onclick="event.preventDefault();document.getElementById('add_id').value = {{ $box->id }}">荷物追加</button>
                        <button class="c-button c-button--bgPink u-mr10" type="button" uk-toggle="target: #modal-delete" onclick="event.preventDefault();document.getElementById('delete_id').value = {{ $box->id }}">削除</button>
                    </td>
                </tr>
                <tr>
                    <th style="width: 200px;">サイト登録日</th>
                    <td>{{ $box->created_at }}</td>
                </tr>
                <tr>
                    <th style="width: 200px;">受取日</th>
                    <td>{{ $box->received_on }}</td>
                </tr>
                <tr>
                    <th>箱ナンバー</th>
                    <td>{{ $box->number }}</td>
                </tr>
                <tr>
                    <th>受け取り日</th>
                    <td>{{ $box->received_on }}</td>
                </tr>
                <tr>
                    <th>ユーザー名</th>
                    <td><a href="{{ route('admin.show.user', $box->user_id ) }}">{{ $box->user->last_name }} {{ $box->user->first_name }}</a></td>
                </tr>
                <tr>
                    <th>詳細</th>
                    <td>{{ $box->detail }}</td>
                </tr>
            </tbody>
        </table>
        @endif
    </div>
</div>
<div class="admin-content-inner">
    <div class="admin-header">
        <h1>箱の荷物一覧</h1>
    </div>
    <div class="admin-body">
        <table class="uk-table uk-table-middle uk-table-responsive uk-table-divider">
            <thead>
                <tr>
                    <th>登録日</th>
                    <th>番号</th>
                    <th>支店<br>担当者</th>
                    <th>サムネイル</th>
                    <th>ステータス</th>
                    <th>リクエスト</th>
                    <th>預入方法</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item->created_at }}</td>
                    <td><a href="{{ route('admin.show.item', $item->id ) }}">{{ $item->number }}</a></td>
                    <td>{{ $box->staff->shop->name }}<br>{{ $box->staff->last_name }} {{ $box->staff->last_name }}</td>
                    <td>
                        <div class="item__img u-w80">
                            <div class="item__img__inner">
                                <img src="{{ $item->oldestImage() }}">
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($item->status == 'now_store')保管中
                        @elseif($item->status == 'request_sale')販売出品中
                        @elseif($item->status == 'now_rental')レンタル出品中
                        @elseif($item->status == 'lend_rental')レンタル貸出中
                        @elseif($item->status == 'done_donate')寄付済み
                        @elseif($item->status == 'done_sale')売却済み
                        @elseif($item->status == 'done_return')返却済み
                        @endif
                    </td>
                    <td>
                        @if($item->request == 0)リクエストなし
                        @elseif($item->request == 1)販売出品リクエスト中
                        @elseif($item->request == 2)販売出品停止リクエスト中
                        @elseif($item->request == 3)レンタルリクエスト中
                        @elseif($item->request == 4)レンタル停止リクエスト中
                        @elseif($item->request == 5)返却リクエスト中
                        @endif
                    </td>
                    <td>
                        {{ $item->storage}}
                    </td>
                    <td>
                        @if($item->status == 'request_sale')
                            <button class="c-button c-button--blue u-mr10" type="button" uk-toggle="target: #modal-sell" onclick="event.preventDefault();document.getElementById('sell_id').value = {{ $item->id }}">販売完了</button>
                        @elseif($item->status == 'now_rental')
                            <button class="c-button c-button--blue" type="button" uk-toggle="target: #modal-rental" onclick="event.preventDefault();document.getElementById('rental_id').value = {{ $item->id }}">レンタル開始</button>
                        @elseif($item->status == 'lend_rental')
                            <button class="c-button c-button--pink" type="button" uk-toggle="target: #modal-return" onclick="event.preventDefault();document.getElementById('return_id').value = {{ $item->id }}">レンタル返却完了</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
