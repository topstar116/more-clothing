@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', '販売代行 荷物一覧 | モアクロ')
@section('description', '販売代行 荷物一覧')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="販売代行 荷物一覧"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>
{{--
<section class="user__content">
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__list l-flex">
                <div class="u-w100per">
                    <a class="c-button c-button--big c-button--blue u-w100per">販売代行を依頼する</a>
                </div>
            </div>
        </div>
    </div>
</section>
--}}
<form method="POST" action="{{ route('custody.sales.stop.request') }}">
@csrf
    <section class="user__content">
        <div class="user__content__box">
            <div class="user__content__box__inner">
                @if(count($items) > 0)
                    @foreach($items as $index => $item)
                    <div class="user__content__box__info l-flex l-v__center l-start">
                        {{-- <div class="u-w30">
                            <label><input class="uk-checkbox" type="checkbox" name="items[]" value="{{ $item->id }}"></label>
                        </div> --}}
                        <div class="u-w80_pc u-w40_sp u-mr10">
                            <div class="item__img">
                                <div class="item__img__inner">
                                    <img src="{{ $item->url }}">
                                </div>
                            </div>
                        </div>
                        <div class="u-wflex1">
                            <table class="item-detail-table">
                                <tr>
                                    <th>依頼日</th>
                                    <td>{{ $item->selling_day }}</td>
                                </tr>
                                <tr>
                                    <th>売却金額</th>
                                    <td>¥{{ number_format($item->selling_price) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="u-w70 l-flex l-v__center l-right">
                            <a class="detail-link" href="{{ route('custody.item.detail', $item->id) }}">
                                詳細へ<img src="/img/icon-arrow-right-circle-blue.png">
                            </a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="user__content__box__info l-flex l-v__center l-start">
                        販売代行中の荷物はありません。
                    </div>
                @endif
                {{--  <div class="user__content__box__info l-flex l-v__center l-start">
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
                                <th>売却金額</th>
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
                        <img src="/img/home-service-three.jpg">
                    </div>
                    <div class="u-wflex1">
                        <table class="item-detail-table">
                            <tr>
                                <th>依頼日</th>
                                <td>2020.12.10</td>
                            </tr>
                            <tr>
                                <th>売却金額</th>
                                <td>2,300円</td>
                            </tr>
                        </table>
                    </div>
                    <div class="u-w70 l-flex l-v__center l-right detail-link">詳細へ<img src="/img/icon-arrow-right-circle-blue.png"></div>
                </div>  --}}
            </div>
        </div>
    </section>
    {{-- <section class="user__content">
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__list l-flex">
                    <div class="u-w100per">
                        <button class="c-button c-button--big c-button--bgPink u-w100per" type="submit">販売代行を停止する</button>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
</form>

@endsection
