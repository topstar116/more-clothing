<template>
    <div>
        <section class="user__content box-detail">
            <div class="user__content__headline">
                <div class="user__content__headline__inner">
                    <div class="user__content__box__list l-flex">
                        <div class="c-radio--customize u-w49per" style="position: relative;">
                            <input id="japan" class="c-radio--hidden" type="radio" name="bank_type" value="0" v-model="bankType">
                            <!-- <label for="japan" class="c-button c-button--big c-button--blue u-w100per u-pr0 u-pl0" @click="panelChange(0)" :class="{'selected': bankType == 0}">ゆうちょ</label> -->
                            <label for="japan" class="c-button c-button--big c-button--blue u-w100per u-pr0 u-pl0" @click="panelChange(0)">ゆうちょ</label>
                        </div>
                        <div class="c-radio--customize u-w49per" style="position: relative;">
                            <input id="other" class="c-radio--hidden" type="radio" name="bank_type" value="1" v-model="bankType">
                            <!-- <label for="other" class="c-button c-button--big c-button--blue u-w100per u-pr0 u-pl0" @click="panelChange(1)" :class="{'selected': bankType == 1}">その他</label> -->
                            <label for="other" class="c-button c-button--big c-button--blue u-w100per u-pr0 u-pl0" @click="panelChange(1)">その他</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ゆうちょ -->
            <div class="user__content__box" v-if="bankType == 0">
                <div class="user__content__box__inner">
                    <div class="user__content__box__gray">
                        <p class="sub-headline">口座記号</p>
                        <input type="text" name="japan_mark" class="uk-input user__content__box__gray__inner" placeholder="12345" :value="sessions['japan_mark']" required="required">
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">口座番号</p>
                        <input type="text" name="japan_number" class="uk-input user__content__box__gray__inner" placeholder="1234567" :value="sessions['japan_number']" required="required">
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">口座名義人</p>
                        <input type="text" name="japan_name" class="uk-input user__content__box__gray__inner" placeholder="モアクロ（全角カタカナ）" :value="sessions['japan_name']" required="required">
                    </div>
                </div>
            </div>

            <!-- その他 -->
            <div class="user__content__box" v-if="bankType == 1">
                <div class="user__content__box__inner">
                    <div class="user__content__box__gray">
                        <p class="sub-headline">銀行名</p>
                        <input type="text" name="financial_name" class="uk-input user__content__box__gray__inner" placeholder="ABC銀行" :value="sessions['financial_name']" required="required">
                    </div>
                    <div class="user__content__box__gray l-flex">
                        <div class="u-w49per">
                            <p class="sub-headline">支店番号</p>
                            <input type="text" name="shop_number" class="uk-input user__content__box__gray__inner" placeholder="123" :value="sessions['shop_number']" required="required">
                        </div>
                        <div class="u-w49per">
                            <p class="sub-headline">支店名</p>
                            <input type="text" name="shop_name" class="uk-input user__content__box__gray__inner" placeholder="本店" :value="sessions['shop_name']" required="required">
                        </div>
                    </div>
                    <div class="user__content__box__gray l-flex">
                        <div class="u-w49per">
                            <p class="sub-headline">口座種別</p>
                            <div class="uk-form-controls">
                                <select v-model="otherType" name="other_type" class="uk-select user__content__box__gray__inner" id="form-horizontal-select" required="required">
                                    <option value="0">普通</option>
                                    <option value="1">当座</option>
                                </select>
                                <!--
                                <select name="other_type" v-model="selectedInfo" class="uk-select user__content__box__gray__inner" id="form-horizontal-select"> -->
                                    <!-- <option v-for="(info, index) in infoList" :key="info.index" :value="info">{{ info.text }}</option> -->
                                    <!-- <option v-for="(info, index) in infoList" :key="index" :value="info">{{ info }}</option>
                                </select>
                                -->
                            </div>
                        </div>
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">口座番号</p>
                        <input type="text" name="other_number" class="uk-input user__content__box__gray__inner" :value="sessions['other_number']" placeholder="1234567" required="required">
                    </div>
                    <div class="user__content__box__gray">
                        <p class="sub-headline">口座名義人</p>
                        <input type="text" name="other_name" class="uk-input user__content__box__gray__inner" :value="sessions['other_name']" placeholder="モアクロ（全角カタカナ）" required="required">
                    </div>
                </div>
            </div>
        </section>
        <section class="user__content">
            <div class="user__content__box">
                <div class="user__content__box__inner">
                    <div class="user__content__box__list l-flex">
                        <div class="u-w49per">
                            <a href="/custody/trade-history" class="c-button c-button--big c-button--pink u-w100per">戻る</a>
                        </div>
                        <div class="u-w49per">
                            <button class="c-button c-button--big c-button--bgBlue u-w100per" type="submit">出金依頼</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        // 必要に応じて、bladeから渡されるデータを定義
        // props: ['sessionParams'],
        props: {
            sessionparams: {
                type: Object
            },
        },
        data() {
            // 必要に応じて変数を定義
            return {
                sessions: this.sessionparams,
                bankType: 0,
                //初期値
                // selectedInfo: {value: 0, text: '普通'},
                // selectedInfo: '普通',
                //選択肢
                // infoList: [ 
                //     {value: 0, text: '普通'},
                //     {value: 1, text: '当座'},     
                // ]
                // infoList: [ '普通', '当座'],
            }
        },
        created: function() {
            // ゆうちょかその他かを選択
            this.bankType = this.sessions['bank_type'] ?? 0
            // その他銀行 口座種別
            this.otherType = this.sessions['other_type']
            
        },
        computed: {
        },
        methods: {
            panelChange: function(num){
                this.bankType = num
            }
        },
        watch: {
        }
    }
</script>
