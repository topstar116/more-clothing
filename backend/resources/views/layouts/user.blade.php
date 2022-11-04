{{-- CSS  --}}
@push('css')
<link rel="stylesheet" href="{{ asset('css/user/common.css') }}">
@endpush
<!DOCTYPE html>
<html lang="ja">
@include("./layouts/parts/head")
<body>
    <div id="app" class="sp__body">
        @yield('content')
        @include("./layouts/parts/user-nav")
    </div>
    <script src="{{ asset('js/app.js')}}"></script>
    <script src="{{ asset('js/bundle.js')}}"></script>
</body>
</html>
