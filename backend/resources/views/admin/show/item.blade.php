@extends('layouts.admin')

<!-- タイトル・メタディスクリプション -->
@section('title', '荷物詳細 | モアクロ')
@section('description', '荷物詳細')

<!-- CSS -->
@push('css')
@endpush

{{-- JS --}}
@push('js')
{{-- <script src="{{ mix('js/confirmDelete.js') }}"></script> --}}
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
    @if(!empty($item))
    {{--  モーダル 荷物 編集  --}}
    <div id="modal-update" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">荷物追加</h2>
            </div>
            
            <form method="POST" action="{{ route('admin.edit.item.store') }}" enctype="multipart/form-data">
                @csrf
                <input id="box_id" name="box_id" type="hidden" value="{{ $item->box_id }}">
                <input id="item_id" name="item_id" type="hidden" value="{{ $item->id }}">
                <div class="uk-modal-body">
                    <div class="user__content__box__gray">
                        <p class="sub-headline">担当支店</p>
                        <select name="shop_id" class="uk-select user__content__box__gray__inner" id="form-horizontal-select">
                            @foreach($shops as $shop)
                                @if($shop->id === $item->shop_id)
                                <option value="{{ $shop->id }}" selected="selected">{{ $shop->name }}</option>
                                @else
                                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">荷物詳細</p>
                        <textarea name="memo" class="uk-input user__content__box__gray__inner" value="{{ $item->memo }}"></textarea>
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">保管方法</p>
                        <select name="how" class="uk-select user__content__box__gray__inner" id="form-horizontal-select">
                            <option value="0" @if($item->how == 0) selected="selected" @endif>箱</option>
                            <option value="1" @if($item->how == 1) selected="selected" @endif>ハンガー</option>
                        </select>
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">荷物画像（最大5枚）</p>
                        <image-upload-component :course='@json($itemImages)'></image-upload-component>
                    </div>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button class="c-button c-button--default uk-modal-close u-mr10" type="button">キャンセル</button>
                    <button class="c-button c-button--bgBlue" type="submit">荷物を変更</button>
                </div>
            </form>
           
        </div>
    </div>

    {{--  モーダル 削除  --}}
    <div id="modal-delete" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">荷物を削除</h2>
            </div>
            <form method="POST" action="{{ route('admin.edit.item.stop') }}">
                @csrf
                <input id="delete_id" name="delete_id" type="hidden" value="{{ $item->id }}">
                <div class="uk-modal-footer uk-text-right">
                    <button class="c-button c-button--default uk-modal-close u-mr10" type="button">キャンセル</button>
                    <button class="c-button c-button--bgPink" type="submit">削除する</button>
                </div>
            </form>
        </div>
    </div>

    {{--  本文  --}}
    <div class="admin-header">
        <h1>荷物詳細</h1>
    </div>
    <div class="admin-body">
        <table class="uk-table uk-table-middle uk-table-responsive uk-table-divider">
            <tbody>
                <tr>
                    <td colspan="2">
                        {{-- <a id="js-modal-confirm" class="uk-button uk-button-default" href="#">Confirm</a> --}}
                        <button class="c-button c-button--bgBlue u-mr10" type="button" uk-toggle="target: #modal-update" onclick="event.preventDefault();">編集</button>
                        <button class="c-button c-button--bgPink" type="button" uk-toggle="target: #modal-delete" onclick="event.preventDefault();document.getElementById('delete_id').value = {{ $item->id }}">削除</button>
                    </td>
                </tr>
                <tr>
                    <th style="width: 200px;">登録日</th>
                    <td>{{ $item->created_at }}</td>
                </tr>
                <tr>
                    <th>番号</th>
                    <td>{{ $item->number }}</td>
                </tr>
                <tr>
                    <th>支店</th>
                    <td>{{ $shop->name }}</td>
                </tr>
                <tr>
                    <th>担当者</th>
                    <td>{{ $item->box->staff->last_name }} {{ $item->box->staff->first_name }}</td>
                </tr>
                <tr>
                    <th>登録画像</th>
                    <td>
                        <div class="l-flex l-start">
                            @foreach($itemImages as $index => $itemImage)
                            <div class="item__img u-w80 item-image-{{ $index }}">
                                <div class="item__img__inner">
                                    <img src="{{ $itemImage->image_url }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>ステータス</th>
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
                </tr>
                <tr>
                    <th>リクエスト</th>
                    <td>
                        @if($item->request == 0)リクエストなし
                        @elseif($item->request == 1)販売出品リクエスト中
                        @elseif($item->request == 2)販売出品停止リクエスト中
                        @elseif($item->request == 3)レンタルリクエスト中
                        @elseif($item->request == 4)レンタル停止リクエスト中
                        @elseif($item->request == 5)返却リクエスト中
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>保管方法</th>
                    <td>
                        {{ $item->storage}}
                    </td>
                </tr>
                <tr>
                    <th>荷物詳細</th>
                    <td>{{ $item->memo }}</td>
                </tr>
            </tbody>
        </table>
    </div>
     @endif
@endsection
