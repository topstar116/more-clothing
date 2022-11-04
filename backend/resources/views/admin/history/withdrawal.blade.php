@extends('layouts.admin')

<!-- タイトル・メタディスクリプション -->
@section('title', '出金履歴 | モアクロ')
@section('description', '出金履歴')

<!-- CSS -->
@push('css')
@endpush

<!-- 本文 -->
@section('content')

    <div class="admin-header">
        <h1>出金履歴</h1>
    </div>
    <div class="admin-body">
        <table class="uk-table uk-table-middle uk-table-responsive uk-table-divider">
            <thead>
                <tr>
                    <th>完了日時</th>
                    <th>対象ユーザー</th>
                    <th>銀行タイプ<br>銀行情報</th>
                    <th>振込金額<br>出金金額/手数料</th>
                    <th>担当者</th>
                </tr>
            </thead>
            <tbody>
                @foreach($withdrawals as $withdrawal)
                <tr>
                    <td>{{ $withdrawal->complete_at }}</td>
                    <td>{{ $withdrawal->user_name1 }} {{ $withdrawal->user_name2 }}</td>
                    <td>
                        @if($withdrawal->bank_type_id == 0)ゆうちょ銀行
                        @elseif($withdrawal->bank_type_id == 1)その他銀行
                        @endif
                        <br>
                        @if($withdrawal->bank_type_id == 0){{ $withdrawal->japan_mark }} {{ $withdrawal->japan_number }} {{ $withdrawal->japan_name }}
                        @elseif($withdrawal->bank_type_id == 1){{ $withdrawal->financial_name }} {{ $withdrawal->shop_name }} {{ $withdrawal->shop_number }} {{ $withdrawal->other_type }} {{ $withdrawal->other_number }} {{ $withdrawal->other_name }}
                        @endif
                    </td>
                    <td>{{ number_format($withdrawal->price) }}円<br>（{{ number_format($withdrawal->fee) }}円/{{ number_format($withdrawal->transfer) }}円）</td>
                    <td>{{ $withdrawal->staff_name1 }} {{ $withdrawal->staff_name2 }}</td>
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
