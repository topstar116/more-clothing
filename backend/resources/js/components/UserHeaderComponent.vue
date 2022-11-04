<template>
    <header id="user-header">
        <div class="header__inner">
            <div class="header__back" v-if="back">
                <a :href="back"><img src="/img/icon-back.png"></a>
            </div>
            <p class="header__title">{{ title }}</p>
            <div class="header__menu">
                <div class="hamburger-menu">
                    <input type="checkbox" id="menu-btn-check" v-model="isMenu" @click="openMenu">
                    <label for="menu-btn-check" class="menu-btn"><span></span></label>
                </div>
            </div>
        </div>
        <div class="user__menu" v-if="isMenu">
            <div class="user__menu__content">
                <p>預かり</p>
                <ul>
                    <li><a href="/custody/box/">保管荷物一覧</a></li>
                    <li><a href="/custody/box/storage-request/">荷物預入リクエスト</a></li>
                    <li><a href="/custody/return/request/">荷物返却リクエスト</a></li>
                </ul>
            </div>
            <div class="user__menu__content">
                <p>販売代行</p>
                <ul>
                    <li><a href="/custody/sales-agency/">販売代行荷物一覧</a></li>
                    <li><a href="/custody/sales-agency/request/">販売代行リクエスト</a></li>
                </ul>
            </div>
            <div class="user__menu__content">
                <p>レンタル</p>
                <ul>
                    <li><a href="/custody/rental/">レンタル荷物一覧</a></li>
                    <li><a href="/custody/rental/request">レンタル出品リクエスト</a></li>
                </ul>
            </div>
            <div class="user__menu__content">
                <p>その他</p>
                <ul>
                    <li><a href="/custody/account/">アカウント情報</a></li>
                    <li><a href="/custody/trade-history/">取引履歴</a></li>
                    <li><a href="/contact-us/">お問い合わせ</a></li>
                    <!-- <li><a href="/custody/news/">お知らせ一覧</a></li> -->
                    <li>
                        <a onclick="event.preventDefault();document.getElementById('logout-form').submit();">ログアウト</a>
                        <form id="logout-form" action="/logout" method="POST" style="display: none;">
                            <input type="hidden" name="_token" :value="csrf">
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>
</template>
<script>
    export default {
        // 必要に応じて、bladeから渡されるデータを定義
        props: ['title', 'back', 'csrf'],
        data() {
            // 必要に応じて変数を定義
            return {
                title: this.title,
                back: this.back,
                isMenu: false,
            }
        },
        created: function() {
        },
        computed: {
        },
        methods: {
            openMenu: function() {
                this.isMenu = !this.isMenu;
            }
        },
        watch: {
        }
    }
</script>
