<!DOCTYPE html>
<html lang="ja">
@include("./layouts/parts/head")
<link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
<body>
    <div id="app" class="admin__wrap l-flex">
        @include('./layouts/parts/admin-sidebar')
        <div class="admin-content u-wflex1">
            <div class="admin-content-inner">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js')}}"></script>
    <script src="{{ asset('js/bundle.js')}}"></script>
</body>
</html>
