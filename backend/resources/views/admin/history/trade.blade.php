@extends('layouts.admin')

<!-- タイトル・メタディスクリプション -->
@section('title', 'レンタル履歴 | モアクロ')
@section('description', 'レンタル履歴')

<!-- CSS -->
@push('css')
@endpush

<!-- 本文 -->
@section('content')

    <div class="admin-header">
        <h1>レンタル履歴</h1>
    </div>
    <div class="admin-body">
        <table class="uk-table uk-table-middle uk-table-responsive uk-table-divider">
            <thead>
                <tr>
                    <th>レンタル開始日</th>
                    <th>レンタル終了日予定日</th>
                    <th>レンタル返却日</th>
                    <th>レンタルユーザー名</th>
                    <th>レンタル価格 / 手数料</th>
                    <th>担当者</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rentalTrades as $rentalTrade)
                <tr>
                    <td>{{ $rentalTrade->start_at }}</td>
                    <td>{{ $rentalTrade->finish_at }}</td>
                    <td>{{ $rentalTrade->return_at }}</td>
                    <td><a href="{{ route('admin.show.rental.user', $rentalTrade->staff_id) }}">{{ $rentalTrade->rental_user_name1 }} {{ $rentalTrade->rental_user_name2 }}</a></td>
                    <td>{{ number_format($rentalTrade->price) }}円 / {{ number_format($rentalTrade->fee) }}円</td>
                    <td>{{ $rentalTrade->staff_name1 }} {{ $rentalTrade->staff_name2 }}</td>
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
