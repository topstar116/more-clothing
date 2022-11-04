@extends('layouts.admin')

<!-- タイトル・メタディスクリプション -->
@section('title', '返却履歴 | モアクロ')
@section('description', '返却履歴')

<!-- CSS -->
@push('css')
@endpush

<!-- 本文 -->
@section('content')

    <div class="admin-header">
        <h1>返却履歴</h1>
    </div>
    <div class="admin-body">
        <table class="uk-table uk-table-middle uk-table-responsive uk-table-divider">
            <thead>
                <tr>
                    <th>商品ID</th>
                    <th>返却希望日時</th>
                    <th>返却郵送会社</th>
                    <th>返却追跡番号</th>
                    <th>到着予定日時</th>
                    <th>担当者</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ships as $ship)
                <tr>
                    <td>{{ $ship->item_id }}</td>
                    <td>{{ $ship->return_request_at }}</td>
                    <td>{{ $ship->company }}</td>
                    <td>{{ $ship->number }}</td>
                    <td>{{ $ship->estimated_arrival_at }}</td>
                    <td>{{ $ship->staff_name1 }} {{ $ship->staff_name2 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
