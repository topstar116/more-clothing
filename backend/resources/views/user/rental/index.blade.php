 @extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', 'レンタル 荷物一覧 | モアクロ')
@section('description', 'レンタル 荷物一覧')

{{-- CSS --}}
@push('css')
@endpush

<!-- 本文 -->
@section('content')
<user-header-component
    title="レンタル 荷物一覧"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>

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

<form method="POST" action="{{ route('custody.rental.stop.request') }}">
@csrf
    <section class="user__content">
        <div class="user__content__box">
            <div class="user__content__box__inner">
                @if(count($items) > 0)
                    @foreach($items as $index => $item)
                    <div class="user__content__box__info l-flex l-v__center l-start">
                        <div class="u-w30">
                            @if($item->request != 4)
                            <label><input class="uk-checkbox" type="checkbox" name="items[]" value="{{ $item->id }}"></label>
                            @endif
                        </div>
                        <div class="u-w80 u-mr10">
                            <img src="{{ $item->url }}">
                        </div>
                        <div class="u-wflex1">
                            <table class="item-detail-table">
                                <tr>
                                    <th>依頼日</th>
                                    <td>{{ $item->date ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>貸出金額</th>
                                    <td>{{ $item->price ?? '' }}円</td>
                                </tr>
                            </table>
                        </div>
                        <div class="u-w70 l-flex l-v__center l-right">
                            <a class="detail-link" href="{{ route('custody.item.detail', $item->id) }}">詳細へ<img src="/img/icon-arrow-right-circle-blue.png"></a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="user__content__box__info l-flex l-v__center l-start">
                        レンタル中の荷物はありません。
                    </div>
                @endif
                {{--
                <div class="user__content__box__info l-flex l-v__center l-start">
                    <div class="u-w30">
                        <label><input class="uk-checkbox" type="checkbox"></label>
                    </div>
                    <div class="u-w80 u-mr10">
                        <img src="/img/home-service-three.jpg">
                    </div>
                    <div class="u-wflex1">
                        <table class="item-detail-table">
                            <tr>
                                <th>依頼日</th>
                                <td>2020.12.10</td>
                            </tr>
                            <tr>
                                <th>貸出金額</th>
                                <td>2,300円</td>
                            </tr>
                        </table>
                    </div>
                    <div class="u-w70 l-flex l-v__center l-right detail-link">詳細へ<img src="/img/icon-arrow-right-circle-blue.png"></div>
                </div>
                <div class="user__content__box__info l-flex l-v__center l-start">
                    <div class="u-w30">
                        <label><input class="uk-checkbox" type="checkbox"></label>
                    </div>
                    <div class="u-w80 u-mr10">
                        <span class="rental-now">レンタル中</span>
                        <img src="/img/home-service-three.jpg">
                    </div>
                    <div class="u-wflex1">
                        <table class="item-detail-table">
                            <tr>
                                <th>依頼日</th>
                                <td>2020.12.10</td>
                            </tr>
                            <tr>
                                <th>貸出金額</th>
                                <td>2,300円</td>
                            </tr>
                        </table>
                    </div>
                    <div class="u-w70 l-flex l-v__center l-right detail-link">詳細へ<img src="/img/icon-arrow-right-circle-blue.png"></div>
                </div>
                --}}
            </div>
        </div>
    </section>
    <section class="user__content">
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__list l-flex">
                    <div class="u-w100per">
                        <button class="c-button c-button--big c-button--bgPink u-w100per" type="submit">レンタル出品を停止する</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>

@endsection
