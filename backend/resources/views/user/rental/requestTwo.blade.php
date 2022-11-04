@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', 'レンタル出品 STEP2 | モアクロ')
@section('description', 'レンタル出品 STEP2')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="レンタル出品 STEP2"
    back="/custody/sales-agency/request"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>
<section class="user__content">
    <div class="user__content__headline">
        <div class="user__content__headline__inner complete-message">
            <div class="step-box">
                <span class="step-box-number one">１</span>
                <span class="step-box-number two now">２</span>
                <span class="step-box-number three">３</span>
            </div>
            <p>希望する条件を選択してください。</p>
        </div>
    </div>
</section>
<form method="POST" action="{{ route('custody.rental.request.two.post') }}">
    @csrf
    <input type="hidden" name="item_id" value="{{ $input_items['item_id'] ?? '' }}">
    <input type="hidden" name="url" value="{{ $input_items['url'] ?? '' }}">
    <section class="user__content">
        <div class="user__content__headline">
            <div class="user__content__headline__inner l-flex l-v__center">
                <p>選択した荷物</p>
            </div>
        </div>
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <div class="item__img">
                        <div class="item__img__inner">
                            <img src="{{ $input_items['url'] ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="user__content">
        <div class="user__content__headline">
            <div class="user__content__headline__inner l-flex l-v__center">
                <p>レンタル出品金額</p>
            </div>
        </div>
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <div class="uk-margin">
                        <div class="uk-form-controls">
                            <select name="price" class="uk-select user__content__box__gray__inner" id="form-horizontal-select">

                                @for ($i = 500; $i <= 20000; $i += 500)
                                <option value="{{ $i }}" @if(isset($input_items['price']) && $input_items['price'] == $i) selected="selected" @endif>{{ number_format($i) }}円</option>
                                {{-- <option value="1000">1,000円</option>
                                <option value="1500">1,500円</option>
                                <option value="2000">2,000円</option>
                                <option value="2500">2,500円</option>
                                <option value="3000">3,000円</option>
                                <option value="3500">3,500円</option>
                                <option value="4000">4,000円</option>
                                <option value="4500">4,500円</option>
                                <option value="5000">5,000円</option>
                                <option value="5500">5,500円</option>
                                <option value="6000">6,000円</option>
                                <option value="6500">6,500円</option>
                                <option value="7000">7,000円</option>
                                <option value="7500">7,500円</option>
                                <option value="8000">8,000円</option>
                                <option value="8500">8,500円</option>
                                <option value="9000">9,000円</option>
                                <option value="9500">9,500円</option>
                                <option value="10000">10,000円</option>
                                <option value="11000">11,000円</option>
                                <option value="12000">12,000円</option>
                                <option value="13000">13,000円</option>
                                <option value="14000">14,000円</option>
                                <option value="15000">15,000円</option>
                                <option value="16000">16,000円</option>
                                <option value="17000">17,000円</option>
                                <option value="18000">18,000円</option>
                                <option value="19000">19,000円</option>
                                <option value="20000">20,000円</option> --}}
                                @endfor
                            </select>
                        </div>
                    </div>
                    <table>
                        <tr>
                            <td class="u-text--sub">※</td>
                            <td class="u-text--sub">レンタル金額から「レンタル手数料」と「クリーニング料金」を差し引いた金額が、手元に残るお金です。</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
    {{--  <section class="user__content">
        <div class="user__content__headline">
            <div class="user__content__headline__inner l-flex l-v__center">
                <p>商品画像を選択する</p>
            </div>
        </div>
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <image-upload-component></image-upload-component>

                </div>
            </div>
        </div>
    </section>  --}}
    <section class="user__content">
        <div class="user__content__headline">
            <div class="user__content__headline__inner l-flex l-v__center">
                <p>その他リクエスト</p>
            </div>
        </div>
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <textarea name="other" class="uk-input user__content__box__gray__inner" value="{{ $input_items['other'] ?? '' }}">{{ $input_items['other'] ?? '' }</textarea>
                </div>
            </div>
        </div>
    </section>
    <section class="user__content">
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__list l-flex">
                    <div class="u-w49per">
                        <button class="c-button c-button--big c-button--pink" name="back" type="submit">前へ戻る</button>
                    </div>
                    <div class="u-w49per">
                        <button class="c-button c-button--big c-button--bgBlue" type="submit">確認画面へ進む</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
@endsection
