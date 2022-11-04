@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', '返却荷物を選択する | モアクロ')
@section('description', '返却荷物を選択する')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="返却荷物を選択する"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>
<form method="POST" action="{{ route('custody.return.request.post') }}">
    @csrf
    <section class="user__content">
        <div class="user__content__box">
            <div class="user__content__box__inner">
                @foreach($boxes as $b_index => $box)
                <div class="user__content__box__info l-flex l-v__center">
                    <div class="u-w60 u-mr20 u-text--bold">
                        <img src="/img/icon_cardboard.png">
                    </div>
                    <div class="u-wflex1 l-flex l-start">
                        @foreach($items[$b_index] as $i_index => $item)
                        @if($item->status == 0 && $item->request == 0)
                        <div class="user__content__box__item return-check">
                        @elseif($item->status == 0 && $item->request == 1)
                        <div class="user__content__box__item return-check item-status item-request-sell">
                        @elseif($item->status == 0 && $item->request == 3)
                        <div class="user__content__box__item return-check item-status item-request-rental">
                        @elseif($item->status == 0 && $item->request == 5)
                        <div class="user__content__box__item return-check item-status item-request-return">
                        @elseif($item->status == 1)
                        <div class="user__content__box__item return-check item-status item-status-sell">
                        @elseif($item->status == 2)
                        <div class="user__content__box__item return-check item-status item-status-rental">
                        @elseif($item->status == 3)
                        <div class="user__content__box__item return-check item-status item-status-rent">
                        @elseif($item->status == 7)
                        <div class="user__content__box__item return-check item-status item-status-donate">
                        @elseif($item->status == 8)
                        <div class="user__content__box__item return-check item-status item-status-sold">
                        @elseif($item->status == 9)
                        <div class="user__content__box__item return-check item-status item-status-return">
                        @endif
                            <div class="item__img">
                                @if($item->status == 0 && $item->request == 0)
                                    <input type="checkbox" name="images[]" value="{{ $item_images[$b_index][$i_index][0]->id ?? '' }}">
                                    <span class="return-check"></span>
                                @endif
                                <div class="item__img__inner">
                                    <img src="{{ $item_images[$b_index][$i_index][0]->image_url ?? '' }}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{--  <div class="user__content__box__item return-check">
                            <div class="item__img">
                                <input type="checkbox">
                                <span class="return-check"></span>
                                <div class="item__img__inner">
                                    <img src="/img/home-service-three.jpg">
                                </div>
                            </div>
                        </div>
                        <div class="user__content__box__item return-check">
                            <div class="item__img">
                                <input type="checkbox">
                                <span class="return-check"></span>
                                <div class="item__img__inner">
                                    <img src="/img/home-service-three.jpg">
                                </div>
                            </div>
                        </div>
                        <div class="user__content__box__item return-check">
                            <div class="item__img">
                                <input type="checkbox">
                                <span class="return-check"></span>
                                <div class="item__img__inner">
                                    <img src="/img/home-service-three.jpg">
                                </div>
                            </div>
                        </div>  --}}
                    </div>
                </div>
                @endforeach
                {{--  <div class="user__content__box__info l-flex l-v__center">
                    <div class="u-w60 u-mr20 u-text--bold">
                        <img src="/img/icon_cardboard.png">
                    </div>
                    <div class="u-wflex1 l-flex l-start">
                        <div class="user__content__box__item return-check">
                            <div class="item__img">
                                <input type="checkbox">
                                <span class="return-check"></span>
                                <div class="item__img__inner">
                                    <img src="/img/home-service-three.jpg">
                                </div>
                            </div>
                        </div>
                        <div class="user__content__box__item return-check">
                            <div class="item__img">
                                <input type="checkbox">
                                <span class="return-check"></span>
                                <div class="item__img__inner">
                                    <img src="/img/home-service-three.jpg">
                                </div>
                            </div>
                        </div>
                        <div class="user__content__box__item return-check">
                            <div class="item__img">
                                <input type="checkbox">
                                <span class="return-check"></span>
                                <div class="item__img__inner">
                                    <img src="/img/home-service-three.jpg">
                                </div>
                            </div>
                        </div>
                        <div class="user__content__box__item return-check">
                            <div class="item__img">
                                <input type="checkbox">
                                <span class="return-check"></span>
                                <div class="item__img__inner">
                                    <img src="/img/home-service-three.jpg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  --}}
            </div>
        </div>
    </section>
    <section class="user__content">
        <div class="user__content__headline">
            <div class="user__content__headline__inner l-flex l-v__center">
                <p>返却希望日</p>
            </div>
        </div>
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <vue-datapicker-component class="uk-input" date="{{ old('date') }}"></vue-datapicker-component>
                </div>
            </div>
        </div>
    </section>
    <section class="user__content">
        <div class="user__content__headline">
            <div class="user__content__headline__inner l-flex l-v__center">
                <p>その他リクエスト</p>
            </div>
        </div>
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <textarea class="user__content__box__gray__inner uk-input" name="request" value="{{ old('request') }}"></textarea>
                </div>
            </div>
        </div>
    </section>
    <section class="user__content">
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__list l-flex">
                    <button class="c-button c-button--big c-button--bgBlue u-w100per" type="submit">確認画面へ進む</button>
                </div>
            </div>
        </div>
    </section>
</form>
@endsection
