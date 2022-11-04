@extends('layouts.admin')

<!-- タイトル・メタディスクリプション -->
@section('title', '荷物一覧 | モアクロ')
@section('description', '荷物一覧')

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

    {{--  モーダル 販売  --}}
    <div id="modal-sell" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">売却完了報告</h2>
            </div>
            <form method="POST" action="{{ route('admin.edit.item.sold') }}" enctype="multipart/form-data">
                @csrf
                <input id="sell_id" name="sell_id" type="hidden" value="">
                <div class="uk-modal-body">
                    <div class="user__content__box__gray">
                        <p class="sub-headline">担当者名前</p>
                        <select name="staff_id" class="uk-select user__content__box__gray__inner" id="form-horizontal-select">
                            
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

    {{--  モーダル レンタル開始  --}}
    <div id="modal-rental" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">レンタル開始報告</h2>
            </div>
            <form method="POST" action="{{ route('admin.edit.item.rental') }}" enctype="multipart/form-data">
                @csrf
                <input id="rental_id" name="rental_id" type="hidden" value="">
                <div class="uk-modal-body">
                    <div class="user__content__box__gray">
                        <p class="sub-headline">担当者名前</p>
                        <select name="staff_id" class="uk-select user__content__box__gray__inner" id="form-horizontal-select">
                           
                        </select>
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">レンタルユーザー</p>
                        <select name="rental_user_id" class="uk-select user__content__box__gray__inner" id="form-horizontal-select">
                            @foreach($rentals as $rental)
                            <option value="{{ $rental->id }}">{{ $rental->name1 }} {{ $rental->name2 }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">レンタル開始日</p>
                        <vue-datapicker-now-component></vue-datapicker-now-component>
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">レンタル終了日</p>
                        <vue-datapicker-fin-component></vue-datapicker-fin-component>
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">レンタル金額</p>
                        <input name="rental_price" class="uk-input user__content__box__gray__inner">
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">手数料</p>
                        <input name="rental_fee" class="uk-input user__content__box__gray__inner">
                    </div>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button class="c-button c-button--default uk-modal-close u-mr10" type="button">キャンセル</button>
                    <button class="c-button c-button--bgPink" type="submit">報告する</button>
                </div>
            </form>
        </div>
    </div>

    {{--  モーダル レンタル返却完了  --}}
    <div id="modal-return" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">レンタル返却完了報告</h2>
            </div>
            <form method="POST" action="{{ route('admin.edit.item.return') }}" enctype="multipart/form-data">
                @csrf
                <input id="return_id" name="return_id" type="hidden" value="">
                <div class="uk-modal-body">
                    <div class="user__content__box__gray">
                        <p class="sub-headline">レンタル返却日</p>
                        <vue-datapicker-now-component></vue-datapicker-now-component>
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">レンタル金額</p>
                        <input name="rental_price" class="uk-input user__content__box__gray__inner">
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">レンタル手数料</p>
                        <input name="rental_fee" class="uk-input user__content__box__gray__inner">
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
        <h1>荷物一覧</h1>
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
                    <td>{{ $item->box->staff->shop->name }}<br>{{ $item->box->staff->last_name }} {{ $item->box->staff->first_name }}</td>
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
                        {{$item->storage}}
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
