<template>
    <header id="header">
        <div class="l-wrap">
            <div class="uk-flex uk-flex-between">
                <div class="header__logo uk-padding-small uk-padding-remove-horizontal">
                    <a href="/">
                        <img src="/img/logo-color.png" alt="モアクロのロゴ">
                    </a>
                </div>
                <div class="header__menu">
                    <nav class="uk-navbar uk-navbar-container">
                        <div class="uk-navbar-left">
                            <a class="uk-navbar-toggle" @click="toggleMenu">
                                <span uk-navbar-toggle-icon></span><span class="uk-margin-small-left">Menu</span>
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!-- メニュー -->
        <div class="header__menu" v-show="isMenu">
            <div class="header__menu__inner">
                <ul>
                    <li><a href="/">トップページ</a></li>
                    <li><a href="/sign-in">ログイン</a></li>
                    <li><a href="/sign-up">新規登録</a></li>
                </ul>
                <ul>
                    <li><a href="/company">会社概要</a></li>
                    <!-- <li><a href="/faq">FAQ</a></li> -->
                    <!-- <li><a href="/tokushoho">特定商取引法</a></li> -->
                    <li><a href="/terms-privacy">プライバシーポリシー</a></li>
                </ul>
                <ul>
                    <li><a href="/faq">利用規約</a></li>
                    <!-- <li><a href="/terms-storage">保管サービス利用規約</a></li> -->
                    <li><a href="/terms-agency">出品代行機能利用規約</a></li>
                    <li><a href="/terms-subscription">サブスクリプション規約</a></li>
                    <!-- <li><a href="/contact">お問い合わせ</a></li>
                    <li><a href="/rental">レンタルアイテム</a></li> -->
                </ul>
            </div>
        </div>
        <!-- overlay -->
        <div class="l-overlay" v-show="isMenu" @click="toggleMenu"></div>
    </header>
</template>
<script>
    export default {
        // 必要に応じて、bladeから渡されるデータを定義
        props: [],
        data() {
            // 必要に応じて変数を定義
            return {
                isMenu: false,
            }
        },
        created: function() {
        },
        computed: {
        },
        methods: {
            toggleMenu: function() {
                this.isMenu = !this.isMenu
            }
        },
        watch: {
        }
    }
</script>
