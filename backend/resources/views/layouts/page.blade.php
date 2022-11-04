
<!DOCTYPE html>
<html lang="ja">
@include("./layouts/parts/head")
<body>
    <div id="app">
        <page-header-component></page-header-component>
        @yield('content')
        @include("./layouts/parts/page-footer")
    </div>
    <script src="{{ asset('js/app.js')}}"></script>
    <script src="{{ asset('js/bundle.js')}}"></script>
</body>
</html>
