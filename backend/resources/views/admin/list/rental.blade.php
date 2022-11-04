@extends('layouts.admin')

<!-- タイトル・メタディスクリプション -->
@section('title', 'レンタル出品中 | モアクロ')
@section('description', 'レンタル出品中')

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
                            @foreach($staffs as $staff)
                            <option value="{{ $staff->id }}">{{ $staff->name1 }} {{ $staff->name2 }}</option>
                            @endforeach
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
        <h1>レンタル出品中</h1>
    </div>
    <div class="admin-body">
        <table class="uk-table uk-table-middle uk-table-responsive uk-table-divider">
            <thead>
                <tr>
                    <th>荷物番号</th>
                    <th>レンタル出品日</th>
                    <th>レンタル金額</th>
                    <th>支店<br>担当者</th>
                    <th>サムネイル</th>
                    <th>預入方法</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($rentalItems as $rentalItem)
                <tr>
                    <td><a href="{{ route('admin.show.item', $rentalItem->id ) }}">{{ $rentalItem->number }}</a></td>
                    <td>{{ $rentalItem->created_at }}</td>
                    <td>{{ number_format($rentalItem->price) }}円</td>
                    <td>{{ $rentalItem->box->staff->shop->name }}<br>{{ $rentalItem->box->staff->last_name }} {{ $rentalItem->box->staff->first_name }}</td>
                    <td>
                        <div class="item__img u-w80">
                            <div class="item__img__inner">
                                <img src="{{ $rentalItem->url }}">
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($rentalItem->how == 0)箱
                        @elseif($rentalItem->how == 1)ハンガー
                        @endif
                    </td>
                    <td style="white-space: nowrap">
                        @if($rentalItem->status == 2)
                            <button class="c-button c-button--blue" type="button" uk-toggle="target: #modal-rental" onclick="event.preventDefault();document.getElementById('rental_id').value = {{ $rentalItem->id }}">レンタル開始</button>
                        @elseif($rentalItem->status == 3)
                            <button class="c-button c-button--pink" type="button" uk-toggle="target: #modal-return" onclick="event.preventDefault();document.getElementById('return_id').value = {{ $rentalItem->id }}">レンタル返却完了</button>
                        @endif
                    </td>
                </tr>
                @endforeach
                {{-- <tr>
                    <td>2020.01.01</td>
                    <td><a href="">荷物ID</a></td>
                    <td>2,000円</td>
                    <td><a href="http://sample.com">http://sample.com</a></td>
                    <td style="white-space: nowrap">
                        <button class="c-button c-button--blue u-mr10" type="button" uk-toggle="target: #modal-ok">レンタル確定</button>
                    </td>
                </tr>
                <tr>
                    <td>2020.01.01</td>
                    <td><a href="">荷物ID</a></td>
                    <td>2,000円</td>
                    <td><a href="http://sample.com">http://sample.com</a></td>
                    <td style="white-space: nowrap">
                        <button class="c-button c-button--blue u-mr10" type="button" uk-toggle="target: #modal-ok">レンタル確定</button>
                    </td>
                </tr>
                <tr>
                    <td>2020.01.01</td>
                    <td><a href="">荷物ID</a></td>
                    <td>2,000円</td>
                    <td><a href="http://sample.com">http://sample.com</a></td>
                    <td style="white-space: nowrap">
                        <button class="c-button c-button--blue u-mr10" type="button" uk-toggle="target: #modal-ok">レンタル確定</button>
                    </td>
                </tr> --}}
            </tbody>
        </table>
    </div>
@endsection
