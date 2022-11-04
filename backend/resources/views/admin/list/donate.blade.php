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

    <div class="admin-header">
        <h1>寄付済み荷物一覧</h1>
    </div>
    <div class="admin-body">
        <table class="uk-table uk-table-middle uk-table-responsive uk-table-divider">
            <thead>
                <tr>
                    <th>荷物番号</th>
                    <th>寄付登録日</th>
                    <th>支店<br>担当者</th>
                    <th>サムネイル</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donateItems as $donateItem)
                <tr>
                    <td><a href="{{ route('admin.show.item', $donateItem->id ) }}">{{ $donateItem->number }}</a></td>
                    <td>{{ $donateItem->created_at }}</td>
                    <td>{{ $donateItem->box->staff->shop->name }}<br>{{ $donateItem->box->staff->last_name }} {{ $donateItem->box->staff->first_name }}</td>
                    <td>
                        <div class="item__img u-w80">
                            <div class="item__img__inner">
                                <img src="{{ $donateItem->oldestImage() }}">
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
