@extends('layouts.user')

{{-- タイトル・メタディスクリプション --}}
@section('title', 'トップページ | モアクロ')
@section('description', 'トップページ')

{{-- CSS --}}
@push('css')
@endpush

{{-- 本文 --}}
@section('content')
<user-header-component
    title="保管荷物"
    :csrf="{{json_encode(csrf_token())}}"
></user-header-component>

{{--  成功メッセージ  --}}
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

{{--  エラーメッセージ  --}}
@if ($errors->any())
<section class="user__content">
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__gray">
                <div class="uk-alert-danger u-mb0" uk-alert>
                    <ul class="u-pl0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{--  本文  --}}
<section class="user__content">
    <div class="user__content__headline">
        <div class="user__content__headline__inner l-flex l-v__center">
            <p>保管荷物一覧</p>
            {{-- <a class="c-button c-button--default" href="">一覧へ</a> --}}
        </div>
    </div>
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__list l-flex l-start">
                @if(count($boxes) > 0)
                @foreach($boxes as $box)
                <div class="user__content__box__item">
                    <a href="{{ route('custody.box.detail', $box->id) }}">
                        <div class="user__content__box__item__inner">
                            <div class="item__img">
                                <img src="/img/icon_cardboard.png">
                            </div>
                            <span class="item__date">{{ $box->created_at->format('Y-m-d') }}</span>
                            <p class="item__number">{{ $box->number }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
                @else
                <p>まだ箱が登録されていません。</p>
                @endif
            </div>
        </div>
    </div>
</section>
<section class="user__content">
    <div class="user__content__headline">
        <div class="user__content__headline__inner l-flex l-v__center">
            <p>お知らせ一覧</p>
            <a class="c-button c-button--default" href="">一覧へ</a>
        </div>
    </div>
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__list l-flex l-start">
                @if(count($blogs) > 0)
                @foreach($blogs as $blog)
                <!-- <div class="user__content__box__list"> -->
                        <!-- <a href="{{ route('custody.box.detail', $box->id) }}"> -->
                    <div class="user__content__blog__item__inner">
                        <div class="user__content__blog__item__inner--check">
                            <input type="checkbox" id="" name="">
                        </div>
                        <div class="user__content__blog__item__inner--con">
                            <div class="user__content__blog__item__inner--con__ttl">
                                <span class="item__date">{{ $blog->created_at->format('Y-m-d') }}</span>
                                <span class="blog_title">{{ $blog->title }}</sapn>
                            </div>
                            <div class="user__content__blog__item__inner--con__body">
                                <span class="item__number">{{ $blog->body }}</span>
                            </div>
                        </div>
                        <div class="right_arrow">
                            <img src="/img/icon-arrow-right-gray.png">
                        </div>
                    </div>
                        <!-- </a> -->
                <!-- </div> -->
                @endforeach
                @else
                <p>まだ箱が登録されていません。</p>
                @endif
            </div>
        </div>
    </div>
</section>
{{-- <section class="user__content">
    <div class="user__content__headline">
        <div class="user__content__headline__inner l-flex l-v__center">
            <p>お知らせ一覧</p>
            <a class="c-button c-button--default" href="">一覧へ</a>
        </div>
    </div>
    <div class="user__content__box">
        <div class="user__content__box__inner">
            <div class="user__content__box__info l-flex l-v__center">
                <div class="info__text u-wflex1">
                    <div class="info__text__detail l-flex l-v__center l-start">
                        <span class="info__time">2020.08.12</span>
                        <span class="info__state green">返却リクエスト・完了</span>
                    </div>
                    <div class="info__text__title">モアクロより、ご自宅へ荷物が発送されました。</div>
                </div>
                <div class="info__next u-w25">
                    <a href="">
                        <img src="/img/icon-arrow-right-gray.png">
                    </a>
                </div>
            </div>
            <div class="user__content__box__info l-flex l-v__center">
                <div class="info__text u-wflex1">
                    <div class="info__text__detail l-flex l-v__center l-start">
                        <span class="info__time">2020.08.12</span>
                        <span class="info__state green">返却リクエスト・完了</span>
                    </div>
                    <div class="info__text__title">モアクロより、ご自宅へ荷物が発送されました。</div>
                </div>
                <div class="info__next u-w25">
                    <a href="">
                        <img src="/img/icon-arrow-right-gray.png">
                    </a>
                </div>
            </div>
            <div class="user__content__box__info l-flex l-v__center">
                <div class="info__text u-wflex1">
                    <div class="info__text__detail l-flex l-v__center l-start">
                        <span class="info__time">2020.08.12</span>
                        <span class="info__state green">返却リクエスト・完了</span>
                    </div>
                    <div class="info__text__title">モアクロより、ご自宅へ荷物が発送されました。</div>
                </div>
                <div class="info__next u-w25">
                    <a href="">
                        <img src="/img/icon-arrow-right-gray.png">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section> --}}
@endsection
