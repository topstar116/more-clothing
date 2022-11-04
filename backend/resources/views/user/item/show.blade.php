@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', '保管荷物 中身詳細 | モアクロ')
@section('description', '保管荷物 中身詳細')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="保管荷物 中身詳細"
    back="<?php //echo $_SERVER['HTTP_REFERER']; ?>"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>
{{--  モーダル：荷物を寄付する  --}}
<div id="modal-donate" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">寄付をする</h2>
        <p>（荷物の権利は、モアクロに属することになります。）</p>
        <form method="POST" action="{{ route('custody.item.donate', ['id' => $item->id]) }}">
            @csrf
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">戻る</button>
                <button class="uk-button uk-button-primary" type="submit">寄付する</button>
            </p>
        </form>
    </div>
</div>

{{--  モーダル：販売代行を停止する  --}}
{{-- <div id="modal-stop-sell" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">販売代行を停止する</h2>
        <p>販売代行で出品中の荷物を、出品停止します。<br>（入れ違いで売れてしまった場合、出品停止ができかねますことを、ご了承くださいませ。）</p>
        <form method="POST" action="{{ route('custody.item.stop.sell', ['id' => $item->id]) }}">
            @csrf
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">戻る</button>
                <button class="uk-button uk-button-primary" type="submit">停止する</button>
            </p>
        </form>
    </div>
</div> --}}

{{--  モーダル：レンタルを停止する  --}}
<div id="modal-stop-rental" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">レンタルを停止する</h2>
        <p>レンタルで出品中の荷物を、出品停止します。<br>（入れ違いで売れてしまった場合、出品停止ができかねますことを、ご了承くださいませ。）</p>
        <form method="POST" action="{{ route('custody.item.stop.rental', ['id' => $item->id]) }}">
            @csrf
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">戻る</button>
                <button class="uk-button uk-button-primary" type="submit">停止する</button>
            </p>
        </form>
    </div>
</div>

{{--  本文  --}}
<section class="user__content box-detail">
    <div class="user__content__headline">
        <div class="user__content__headline__inner l-flex l-center l-v__center">
            <div class="headline__item__img">
                <div class="item__img">
                    <div class="item__img__inner">
                        <img src="{{ $item_image->image_url ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="headline__item__info">
                {{--  <span class="item__category">衣類</span>  --}}
                <span class="item__number">{{ $item->number ?? '' }}</span>
                @if($item->status == 'now_store' || $item->status == 'ready_return' || $item->status == 'request_sale' || $item->status == 'ready_sale'|| $item->status == 'now_sale' || $item->status == 'now_rental')
                <a class="c-button c-button--pink u-mt20" href="#modal-donate" uk-toggle>荷物を寄付する！</a>
                @endif
            </div>
        </div>
    </div>
    @if($item->request != 1 && $item->request != 2 && $item->request != 3 && $item->request != 4 && $item->request != 5)
        @if($item->status == 'now_store' || $item->status == 'ready_return' || $item->status == 'now_rental' || $item->status == 'negotiate_rental')
            <div class="user__content__box">
                <div class="user__content__box__inner">
                    <div class="user__content__box__list l-flex">
                        @if($item->status == 'ready_return')
                            <div class="u-w100per">
                                <a href= "" class="c-button c-button--big c-button--pink u-w100per">返却リクエストをキャンセルする </a>
                            </div> 
                        @endif  
                        @if($item->status == 'ready_return')
                        <!-- <div class="u-w100per">
                            <a class="c-button c-button--big c-button--pink u-w100per" href="#modal-stop-sell" uk-toggle>販売代行を停止</a>
                        </div>  -->
                        @elseif($item->status == 'now_store' || $item->status == 'negotiate_rental' || $item->status == 'now_rental')
                            <div class="u-w49per">
                                <form method="POST" action="">
                                    @if($item->status == 'now_store')
                                    <a class="c-button c-button--big c-button--blue u-w100per" href="{{ route('custody.sales.request.two', ['item_id' => $item->id, 'url' => $item_image->image_url ?? '']) }}">販売代行を依頼</a>
                                    @elseif($item->status == 'negotiate_rental' || $item->status == 'now_rental')
                                    <a href="" class="c-button c-button--big c-button--blue u-w100per">出品情報を編集する</a>
                                    @endif
                                </form>
                            </div>
                            <div class="u-w49per">
                                @if($item->status == 'now_store')
                                <a class="c-button c-button--big c-button--blue u-w100per" href="{{ route('custody.rental.request.two', ['item_id' => $item->id, 'url' => $item_image->image_url ?? '']) }}">レンタルに出品する</a>
                                @elseif($item->status == 'negotiate_rental' || $item->status == 'now_rental')
                                <a class="c-button c-button--big c-button--pink u-w100per" href="#modal-stop-rental" uk-toggle>レンタル出品停止</a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__list l-flex l-center">
                    <span class="u-text--bold u-text--big">リクエスト中のため、操作できません。</span>
                </div>
            </div>
        </div>
    @endif
</section>
<section class="user__content">
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">ステータス</div>
                <div class="u-wflex1">
                    @if($item->status == 'now_store')保管中 <a href="{{ route('custody.return.request.confirm', ['item_id' => $item->id]) }}" class="u-text--link">(返却依頼)</a>
                    @elseif($item->status == 'ready_return')返却リクエストをキャンセルする
                    @elseif($item->status == 'request_sale')販売出品リクエスト中
                    @elseif($item->status == 'ready_sale')レンタル出品中
                    @elseif($item->status == 'now_sale')販売代行出品中
                    @elseif($item->status == 'done_donate')寄附済
                    @elseif($item->status == 'now_rental')レンタル出品中
                    @elseif($item->status == 'done_sale')売却済み
                    @elseif($item->status == 'done_return')返却済み
                    @elseif($item->status == 'negotiate_rental') レンタル交渉中
                        @if($detail)返却済み
                        @else返送手続き中（5営業日以内に対応いたします。）
                        @endisset
                    @endif
                </div>
            </div>
            @if($item->status == 'request_sale')
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">要望</div>
                <div class="u-wflex1">
                    {{$detail->detail}}
                </div>
            </div>
            @endif
            @if($item->status == 'now_sale')
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">販売URL</div>
                <div class="u-wflex1">
                        {{$detail->sale_url}}
                </div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">販売開始日</div>
                <div class="u-wflex1">
                    {{$detail->start_on}}
                </div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">販売価格</div>
                <div class="u-wflex1">
                    {{$detail->sale_price}}円
                </div>
            </div>
            @endif
            @if($item->status == 'now_rental' || $item->status == 'negotiate_rental') 
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">レンタルURL</div>
                <div class="u-wflex1">
                    {{$detail->sale_url}}
                </div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">レンタル日</div>
                <div class="u-wflex1">
                    {{$detail->created_at->format('Y-m-d');}}
                </div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">レンタル価格</div>
                <div class="u-wflex1">
                    {{$detail->price}}円
                </div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">保管方法</div>
                <div class="u-wflex1">箱（<a class="u-text--link" href="">ハンガーに変更</a>）</div>
            </div>
            @endif
            @if($item->status == 'ready_return' || $item->status == 'request_sale' || $item->status == 'ready_sale')
            <div class="user__content__box__info l-flex">
                @if($item->status == 'ready_return')
                    <div class="u-w130 u-text--bold">リクエスト日</div>
                    <div class="u-wflex1">
                    {{$detail->created_at->format('Y-m-d');}}
                </div>
                    @elseif($item->status == 'request_sale' || $item->status == 'ready_sale')
                    <div class="u-w130 u-text--bold">依頼日</div>
                @endif
                <div class="u-wflex1">
                    {{$detail->created_at->format('Y-m-d');}}
                </div>
            </div>
            @endif
            @if($item->status == 'now_store')
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">保管方法</div>
                <div class="u-wflex1">箱@if($item->request != 5)（<a class="u-text--link" href="{{ route('custody.return.request.confirm', ['item_id' => $item->id]) }}">ハンガーに変更</a>）@endif</div>
            </div>
            @elseif($item->status == 'done_sale')
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">販売URL</div>
                <div class="u-wflex1"><a class="u-text--link" href="{{ $detail->site_url ?? '' }}" target="_blank" rel="nofollow noopener">{{ $detail->site_url ?? '' }}</a></div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">販売開始日</div>
                <div class="u-wflex1">{{ $detail->created_at->format('Y-m-d') ?? '' }}</div>
            </div>

            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">売却日</div>
                <div class="u-wflex1">{{ $detail->sold_on ?? '' }}</div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">売却金額</div>
                <div class="u-wflex1">{{ $detail->price ?? '' }}円</div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">お客様利益</div>
                <div class="u-wflex1">{{ $detail->profit ?? '' }}円</div>
            </div>
            @elseif($item->status == 'done_donate')
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">寄付日</div>
                <div class="u-wflex1">{{ $detail->created_at->format('Y-m-d ') ?? '' }}</div>
            </div>
            @elseif($item->status == '3')
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">レンタルURL</div>
                <div class="u-wflex1"><a class="u-text--link" href="{{ $detail->url ?? '' }}" target="_blank" rel="nofollow noopener">{{ $detail->url ?? '' }}</a></div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">レンタル日 </div>
                <div class="u-wflex1">{{$detail->start_on ?? '' }}</div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">返却予定日</div>
                <div class="u-wflex1">{{ $detail->finish_at ?? '' }}</div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">保管方法</div>
                {{-- <div class="u-wflex1">箱（<a class="u-text--link" href="">ハンガーに変更</a>）</div> --}}
                <div class="u-wflex1">箱</div>
            </div>
            @elseif($item->status == 8)
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">売却日</div>
                <div class="u-wflex1">{{ $detail->selling_day ?? ''}}</div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">売却金額</div>
                <div class="u-wflex1">¥{{ number_format($detail->selling_price) ?? '' }}</div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">売却手数料</div>
                <div class="u-wflex1">¥{{ number_format($detail->fee) ?? '' }}</div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">送料</div>
                <div class="u-wflex1">¥{{ number_format($detail->shipping) }}</div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">お客様利益</div>
                <div class="u-wflex1">¥{{ number_format($detail->profit) }}</div>
            </div>
            @elseif($item->status == 'done_return')
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">発送会社</div>
                <div class="u-wflex1">{{ $detail->carrier_name ?? '' }}</div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">追跡番号</div>
                <div class="u-wflex1">{{ $detail->tracking_number ?? '' }}</div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">返却手続き日</div>
                <div class="u-wflex1">{{ $detail->request_on ?? '' }}</div>
            </div>
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">返却予定日</div>
                <div class="u-wflex1">{{ $detail->estimated_arrival_on ?? '' }}</div>
            </div>
            @endif
            <div class="user__content__box__info l-flex">
                <div class="u-w130 u-text--bold">預かり日</div>
                <div class="u-wflex1">{{ $item->created_at->format('Y-m-d') ?? '' }}</div>
            </div>
        </div>
    </div>
</section>
@endsection
