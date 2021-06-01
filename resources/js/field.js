Nova.booting((Vue, router, store) => {
    Vue.component('index-scheduler-expression', require('./components/expression/IndexField'))
    Vue.component('detail-scheduler-expression', require('./components/expression/DetailField'))
    Vue.component('form-scheduler-expression', require('./components/expression/FormField'))

    Vue.component('index-scheduler-argument', require('./components/argument/IndexField'))
    Vue.component('detail-scheduler-argument', require('./components/argument/DetailField'))
    Vue.component('form-scheduler-argument', require('./components/argument/FormField'))
})
