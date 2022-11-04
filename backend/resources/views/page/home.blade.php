@extends('layouts.page')

<!-- タイトル・メタディスクリプション -->
@section('title', 'トップページ | モアクロ')
@section('description', 'トップページ')

<!-- CSS -->
@push('css')
<link rel="stylesheet" href="{{ asset('css/page/home.css') }}">
@endpush

<!-- 本文 -->
@section('content')
    <section class="home__screen">
        <div class="l-wrap">
            <div class="l-wrap--inner">
                <div class="home__screen__text uk-card uk-card-default uk-card-body">
                    <p>1箱たった<span class="u-text--big">300</span>円！<br>預けて、売れる！</p>
                </div>
            </div>
        </div>
    </section>
    <section class="home__link">
        <div class="l-wrap">
            <div class="uk-grid-small uk-child-width-expand@s uk-text-center" uk-grid>
                <div>
                    <a class="uk-button uk-button-default uk-button-large uk-width-1-1 u-color--pink" href="sign-in">ログイン</a>
                </div>
                <div>
                    <a class="uk-button uk-button-default uk-button-large uk-width-1-1 u-color--pink" href="/sign-up">新規登録</a>
                </div>
            </div>
        </div>
    </section>
    <section class="home__content u-bgColor--gray">
        <div class="l-wrap">
            <div class="home__headline">
                <span>ABOUT</span>
                <h2>MOREクロとは？</h2>
            </div>
            <div class="home__summary">
                <p>1箱300円から預けられる<br>クラウド型収納サービスです。</p>
                <p>さらに、預けた商品を<br>「レンタル」や「販売」<br>することも可能です！</p>
            </div>
        </div>
    </section>
    <section class="home__content home__service u-bgColor--white">
        <div class="l-wrap">
            <div class="home__headline">
                <span>SERVICE</span>
                <h2>MOREクロができること</h2>
            </div>
            <div class="uk-child-width-expand@s" uk-grid>
                <div class="home__service__box one">
                    <div class="home__service__box__headline">
                        <h3>荷物預かりサービス</h3>
                    </div>
                    <div class="home__service__box__img">
                        <img src="/img/home-service-one.jpg">
                    </div>
                    <div class="home__service__box__text">
                        <p>ああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ</p>
                    </div>
                </div>
                <div class="home__service__box two">
                    <div class="home__service__box__headline">
                        <h3>販売代行サービス</h3>
                    </div>
                    <div class="home__service__box__img">
                        <img src="/img/home-service-two.png">
                    </div>
                    <div class="home__service__box__text">
                        <p>ああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ</p>
                    </div>
                </div>
                <div class="home__service__box three">
                    <div class="home__service__box__headline">
                        <h3>レンタルサービス</h3>
                    </div>
                    <div class="home__service__box__img">
                        <img src="/img/home-service-three.jpg">
                    </div>
                    <div class="home__service__box__text">
                        <p>ああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="home__content home__flow u-bgColor--gray">
        <div class="l-wrap">
            <div class="home__headline">
                <span>FLOW</span>
                <h2>荷物預かりフロー</h2>
            </div>
            <div class="uk-flex-center" uk-grid>
                <div class="home__service__box one">
                    <div class="home__service__box__headline">
                        <h3>ユーザー登録</h3>
                    </div>
                    <div class="home__service__box__img">
                        <img src="/img/home-flow-one.jpg">
                    </div>
                    <div class="home__service__box__text">
                        <p>ああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ</p>
                    </div>
                </div>
                <div class="home__service__box two">
                    <div class="home__service__box__headline">
                        <h3>商品の梱包・発送</h3>
                    </div>
                    <div class="home__service__box__img">
                        <img src="/img/home-flow-two.jpg">
                    </div>
                    <div class="home__service__box__text">
                        <p>ああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="home__content home__price u-bgColor--white">
        <div class="l-wrap">
            <div class="home__headline">
                <span>PRICE</span>
                <h2>モアクロ料金表</h2>
            </div>
            <div class="price__table">
                <table class="uk-table uk-table-justify uk-table-divider">
                    <thead>
                        <tr>
                            <th class="uk-width-small">サービス種類</th>
                            <th>料金</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>預かり金</td>
                            <td>一律300円/月</td>
                        </tr>
                        <tr>
                            <td>ハンガー保管代</td>
                            <td>70円/月</td>
                        </tr>
                        <tr>
                            <td>クリーニング代</td>
                            <td>一律1,500-2,000円<br>(アイテムにより変動)※1</td>
                        </tr>
                        <tr>
                            <td>取り出し代</td>
                            <td>1,200円<br>(箱サイズにより変動)/回</td>
                        </tr>
                        <tr>
                            <td>箱追加時の<br>月額保管料・作業料</td>
                            <td>2,200円/回</td>
                        </tr>
                        <tr>
                            <td>返送送料</td>
                            <td>※2</td>
                        </tr>
                    </tbody>
                </table>
                <p>※1 2,000円以上かかる場合、別途ご連絡致します。</p>
                <p>※2 お送りいただいた箱の中に、規定外の商品が含まれていた場合、サイトに登録されている住所に返送させていただきます。その際の送料は、アイテムサイズ・点数により異なります。</p>
            </div>
        </div>
    </section>
@endsection



