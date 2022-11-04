import { createApp } from 'vue'

createApp({ components:{
    // page
    'page-header-component': require('./components/PageHeaderComponent.vue').default,
    // user
    'user-header-component': require('./components/UserHeaderComponent.vue').default,
    // 画像アップロード
    'image-upload-component': require('./components/ImageUploadComponent.vue').default,
    // 出金リクエスト
    'request-payment-component': require('./components/RequestPaymentComponent.vue').default,
    // datacker
    'vue-datapicker-component': require('./components/VueDatapickerComponent.vue').default,
    'vue-datapicker-now-component': require('./components/VueDatapickerNowComponent.vue').default,
    'vue-datapicker-fin-component': require('./components/VueDatapickerFinComponent.vue').default,
    // 出金方法を選択するコンポーネント
    'how-withdrawal-component': require('./components/HowWithdrawalComponent.vue').default,
}}).mount('#app')
