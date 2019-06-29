Nova.booting((Vue, router, store) => {
    Vue.component('index-nova-state-select', require('./components/IndexField'))
    Vue.component('detail-nova-state-select', require('./components/DetailField'))
    Vue.component('form-nova-state-select', require('./components/FormField'))
})
