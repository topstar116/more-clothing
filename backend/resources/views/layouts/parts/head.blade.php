<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="robots" content="noindex">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - おけいcom</title>
    <meta name="description" content="@yield('description')">

    <!-- OGPタグ/twitterカード -->
    <meta property="og:url" content="ページのURL" />
    <meta property="og:title" content="ページのタイトル" />
    <meta property="og:type" content="ページのタイプ">
    <meta property="og:description" content="記事の抜粋" />
    <meta property="og:image" content="画像のURL" />
    <meta name="twitter:card" content="カード種類" />
    <meta name="twitter:site" content="@Twitterユーザー名" />
    <meta property="og:site_name" content="サイト名" />
    <meta property="og:locale" content="ja_JP" />
    <meta property="fb:app_id" content="appIDを入力" />
    <link rel="shortcut icon" href="{{ asset('/img/common/favicon.png') }}" type="image/x-icon" />
    <!-- スマホ用アイコン画像 -->
    <link rel="apple-touch-icon-precomposed" href="{{ asset('/img/common/favicon.png') }}" />

    <!-- Windows用タイル設定 -->
    <meta name="msapplication-TileImage" content="画像のURL" />
    <meta name="msapplication-TileColor" content="カラーコード（例：#F89174）"/>

    <!-- フィードページの指定 -->
    <link rel="alternate" type="application/rss+xml" title="フィード" href="フィードページのURL" />

    <!-- css -->
    {{--  <link rel="stylesheet" href="{{ asset('css/app.css') }}">  --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    {{--  <link rel="stylesheet" href="{{ asset('js/uikit/css/uikit-rtl.min.css') }}">  --}}
    <link rel="stylesheet" href="{{ asset('js/uikit/css/uikit.min.css') }}">
    @stack('css')

    <!-- JS -->
    @stack('js')

</head>
