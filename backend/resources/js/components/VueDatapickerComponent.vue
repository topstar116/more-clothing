<template>
    <vuejs-datacpicker
        v-model="this.default"
        :format="DatePickerFormat"
        :locale="locale"
        :lowerLimit="from"
        :upperLimit="to"
        :disabled-dates="disabledDates"
        name="date"
    ></vuejs-datacpicker>
</template>

<script>
    import Datepicker from 'vue3-datepicker'
    import ja from 'date-fns/locale/ja'

    export default {
        props: ['date'],
        data() {
            // 必要に応じて変数を定義
            return {
                default: this.date ?? '2021-03-01',
                DatePickerFormat: 'yyyy-MM-dd',
                locale: ja,
                from: new Date().setDate(new Date().getDate() + 6),
                to: new Date().setMonth(new Date().getMonth() + 3),
            }
        },
        components : {
            'vuejs-datacpicker': Datepicker,
        }
    }
</script>
