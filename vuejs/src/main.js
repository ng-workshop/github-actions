import '@babel/polyfill'
import 'mutationobserver-shim'

import Vue from 'vue'
import App from './App.vue'

import router from './router'
import store from './store'

import './plugins/bootstrap-vue'
import './plugins/filters'
import './plugins/functions'
import './plugins/vee-validate'

import './assets/scss/custom.scss'

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
