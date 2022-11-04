@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', '返却荷物 確認画面 | モアクロ')
@section('description', '返却荷物 確認画面')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="返却荷物 確認画面"
    back="/custody/return/request/"
    :csrf="{{json_encode(csrf_token())}}"
>
</user-header-component>
<form method="POST" action="{{ route('custody.return.request.confirm.post') }}">
    @csrf
    <section class="user__content">
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__info l-flex l-v__center">
                    <div class="u-wflex1 l-flex l-start">
                        @foreach($images as $image)
                        <div class="user__content__box__item">
                            <div class="user__content__box__item__inner">
                                <div class="item__img">
                                    <div class="item__img__inner">
                                        <img src="{{ $image->image_url }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="user__content">
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__list l-flex">
                    <a href="" class="c-button c-button--pink u-w100per">不要な荷物を「お金」に変えてみる？ </a>
                </div>
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
                    {{ $input['date'] }}
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
                    {{ $input['request'] }}
                </div>
            </div>
        </div>
    </section>
    <section class="user__content">
        <div class="user__content__headline">
            <div class="user__content__headline__inner l-flex l-v__center">
                <p>注意事項</p>
            </div>
        </div>
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__gray">
                    <div class="uk-alert-danger" uk-alert>
                        <table>
                            <tr>
                                <td>１．</td>
                                <td>返却希望日時は、年末年始及びゴールデンウィークなど、連休前後は大幅にズレる可能性があります。大幅にズレる場合には、メールにてご連絡させていただきます。</td>
                            </tr>
                            <tr>
                                <td>２．</td>
                                <td>商品確認後、送料の最終確定金額をメールでお送りさせていただきます。振り込み完了後、翌日に発送いたします。</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="user__content">
        <div class="user__content__box">
            <div class="user__content__box__inner">
                <div class="user__content__box__list l-flex">
                    <button class="c-button c-button--big c-button--pink u-w49per" type="submit" name="back">入力画面に戻る</button>
                    <button class="c-button c-button--big c-button--bgBlue u-w49per" type="submit">返却荷物を確定する</button>
                </div>
            </div>
        </div>
    </section>
</form>
@endsection
