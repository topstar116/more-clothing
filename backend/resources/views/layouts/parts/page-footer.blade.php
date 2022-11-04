<footer id="footer">
    <div class="l-wrap">
        <div class="footer__box">
            <div class="footer__box__headline">サービス</div>
            <ul class="uk-flex uk-flex-wrap">
                <li><a href="{{ route('home') }}">トップページ</a></li>
                <li><a href="{{ route('company') }}">会社概要</a></li>
                {{--  <li><a href="{{ route('faq') }}">FAQ</a></li>  --}}
                {{--  <li><a href="{{ route('tokushoho') }}">特定商取引法</a></li>  --}}
                <li><a href="{{ route('terms.privacy') }}">プライバシーポリシー</a></li>
                <li><a href="{{ route('contact') }}">お問い合わせ</a></li>
            </ul>
        </div>
        <div class="footer__box">
            <div class="footer__box__headline">規約</div>
            <ul class="uk-flex uk-flex-wrap">
                <li><a href="{{ route('terms') }}">利用規約</a></li>
                <li><a href="{{ route('terms') }}">サービス利用規約</a></li>
                {{--  <li><a href="{{ route('terms.storage') }}">保管サービス利用規約</a></li>  --}}
                <li><a href="{{ route('terms.agency') }}">出品代行機能利用規約</a></li>
                <li><a href="{{ route('terms.subscription') }}">サブスクリプション規約</a></li>
            </ul>
        </div>
    </div>
</footer>
