@extends('layouts.page')

<!-- タイトル・メタディスクリプション -->
@section('title', 'サブスクリプション利用規約 | モアクロ')
@section('description', 'サブスクリプション利用規約')

<!-- CSS -->
@push('css')
<link rel="stylesheet" href="{{ asset('css/page/other.css') }}">
@endpush

<!-- 本文 -->
@section('content')
<section class="other__screen">
    <div class="l-wrap">
        <h1>サブスクリプション利用規約</h1>
    </div>
</section>
<section class="other__content page__other">
    <div class="l-wrap">
        <article class="uk-article">
            <h2>注意事項</h2>
            <div class="uk-child-width-expand@s" uk-grid>
                <ul class="uk-list uk-list-disc">
                    <li>当社が箱を受け取った日時から、サービス利用開始とみなします。初月から料金が発生します。利用料金は一定となります。</li>
                    <li>当サービスでは最低利用期間を設けています。入庫月から翌月末までの、ボックスのお取り出しについては、下記の早期取り出し料金がかかります。
                        <ul class="uk-list uk-list-disc">
                            <li>入庫月に取り出した場合：2ヶ月分の通常利用料金相当額</li>
                            <li>入庫月の翌月に取り出した場合：1ヶ月分の通常料金利用料金相当額</li>
                        </ul>
                    </li>
                    <li>利用期間中、箱の追加やオプションの利用を希望される場合は、通常料金にて利用いただけます。</li>
                    <li>重量については、1箱あたり20Kg以内に収めてください。</li>
                    <li>取り出し回数の数え方は、1箱分の取り出しを「1回」と数えます。例えば、3箱をそれぞれ1回ずつ取り出した場合、 1箱を3回取り出した場合、いずれも3回のカウントです。</li>
                    <li>複数点のアイテムを指定して取り出すことが可能です。その場合でも、ボックス1箱に収まる限りは、1回分の取り出しとなります。</li>
                    <li>本プランは、他のクーポン・キャンペーンと併用できません。</li>
                </ul>
            </div>
        </article>
    </div>
</section>
@endsection
