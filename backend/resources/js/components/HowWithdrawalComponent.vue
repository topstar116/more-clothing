<template>
    <div>
        <section class="user__content">
            <div class="user__content__box">
                <div class="user__content__box__inner">
                    <div class="user__content__box__gray">
                        <div class="uk-form-controls">
                            <p class="sub-headline">出金金額</p>
                            <select name="point" v-model="deposit" class="uk-select user__content__box__gray__inner" id="form-horizontal-select">
                                <option v-for="(point, index) in points" :value="point">{{ point.toLocaleString() }}円</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="user__content">
            <div class="user__content__box">
                <div class="user__content__box__inner">
                    <div class="user__content__box__gray">
                        <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                            <label><input class="uk-radio" type="radio" name="fee" value="300" v-model="type">　通常出金（3営業日以内 / 300円）</label>
                        </div>
                        <div class="uk-grid-small uk-child-width-auto uk-grid">
                            <label><input class="uk-radio" type="radio" name="fee" value="600" v-model="type">　スピード出金（翌営業日 / 600円）</label>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="user__content">
            <div class="user__content__box">
                <div class="user__content__box__inner">
                    <div class="user__content__box__gray">
                        <table class="c-table--price">
                            <tr>
                                <th>残金</th>
                                <td>{{ deposit }}円</td>
                            </tr>
                            <tr class="border">
                                <th>手数料</th>
                                <td>{{ type }}円</td>
                            </tr>
                            <tr>
                                <th>振込金額</th>
                                <td>{{ calculation }}円 <input type="hidden" name="transfer" :value="calculation"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        // 必要に応じて、bladeから渡されるデータを定義
        // props: ['points'],
        props: {
            points: {
                type: Array
            },
            sessionparams: {
                type: Object
            },
        },
        data() {
            // 必要に応じて変数を定義
            return {
                sessions: this.sessionparams,
                points: this.points,
                deposit: '',
                type: '',
            }
        },
        created: function() {
            // 出金する金額の初期設定
            this.deposit = this.sessions['point'] ?? 1000;
            // 振り込み方法の選択
            this.type = this.sessions['fee'] ?? 300;
        },
        computed: {
            calculation: function() {
                return this.deposit - this.type;
            }
        },
        methods: {},
        watch: {}
    }
</script>
