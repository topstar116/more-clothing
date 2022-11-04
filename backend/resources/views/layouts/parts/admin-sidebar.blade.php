<sidebar class="admin-sidebar u-w240">
    <div class="admin-sidebar-content">
        <ul class="uk-nav uk-nav-default">
            <li class="uk-active">リクエスト</li>
            <li class="uk-parent">
                <ul class="uk-nav-sub">
                    <li><a href="{{ route('admin.request.withdrawal') }}">出金</a></li>
                    <li><a href="{{ route('admin.request.return') }}">返却</a></li>
                    <li><a href="{{ route('admin.request.sales') }}">販売代行</a></li>
                    <li><a href="{{ route('admin.request.rental') }}">レンタル出品</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="admin-sidebar-content">
        <ul class="uk-nav uk-nav-default">
            <li class="uk-active">停止リクエスト</li>
            <li class="uk-parent">
                <ul class="uk-nav-sub">
                    {{-- <li><a href="{{ route('admin.stop.request.sales') }}">販売代行停止</a></li> --}}
                    <li><a href="{{ route('admin.stop.request.rental') }}">レンタル停止</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="admin-sidebar-content">
        <ul class="uk-nav uk-nav-default">
            <li class="uk-active">新規追加</li>
            <li class="uk-parent">
                <ul class="uk-nav-sub">
                    <li><a href="{{ route('admin.add.box') }}">箱を追加</a></li>
                    <li><a href="{{ route('admin.add.shop') }}">支店を追加</a></li>
                    <li><a href="{{ route('admin.add.staff') }}">担当者を追加</a></li>
                    <li><a href="{{ route('admin.add.rental.user') }}">レンタルユーザーを追加</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="admin-sidebar-content">
        <ul class="uk-nav uk-nav-default">
            <li class="uk-active">一覧</li>
            <li class="uk-parent">
                <ul class="uk-nav-sub">
                    <li><a href="{{ route('admin.list.user') }}">ユーザー</a></li>
                    <li><a href="{{ route('admin.list.rental.user') }}">レンタルユーザー</a></li>
                    <li><a href="{{ route('admin.list.shop') }}">支店</a></li>
                    <li><a href="{{ route('admin.list.staff') }}">担当者</a></li>
                    <li><a href="{{ route('admin.list.box') }}">箱</a></li>
                    <li><a href="{{ route('admin.list.item') }}">荷物</a></li>
                    <li><a href="{{ route('admin.list.sales.item') }}"> - 販売代行出品中</a></li>
                    <li><a href="{{ route('admin.list.rental.item') }}"> - レンタル出品中</a></li>
                    <li><a href="{{ route('admin.list.donate.item') }}"> - 寄付済み</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="admin-sidebar-content">
        <ul class="uk-nav uk-nav-default">
            <li class="uk-active">履歴</li>
            <li class="uk-parent">
                <ul class="uk-nav-sub">
                    <li><a href="{{ route('admin.history.withdrawal') }}">出金履歴</a></li>
                    <li><a href="{{ route('admin.history.return') }}">返却履歴</a></li>
                    <li><a href="{{ route('admin.history.trade') }}">レンタル履歴</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="admin-sidebar-content">
        <ul class="uk-nav uk-nav-default">
            <li class="uk-active">その他</li>
            <li class="uk-parent">
                <ul class="uk-nav-sub">
                    <li>
                        <a onclick="event.preventDefault();document.getElementById('logout-form').submit();">ログアウト</a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</sidebar>
