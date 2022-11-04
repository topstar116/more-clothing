@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', '出金リクエスト 完了 | モアクロ')
@section('description', '出金リクエスト 完了')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="出金リクエスト 完了"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>

<section class="user__content">
    <div class="user__content__headline">
        <div class="user__content__headline__inner complete-message">
            <p class="message">COMPLETE！</p>
            <p>出金依頼が完了しました！<br>10日以内に、対応させていただきます。</p>
        </div>
    </div>
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__info u-textAlign__center">
                <a class="u-text--link" href="{{ route('custody.trade.history') }}">取引履歴一覧へ</a>
            </div>
        </div>
    </div>
</section>
@endsection
