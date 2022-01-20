/**
 * Router
 */
import VueRouter from 'vue-router'

import routeDefaults from '@/router/defaults'
import routeAstronauts from '@/router/astronauts'

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [routeDefaults, routeAstronauts],
})

/**
 * VueLocal
 */
import { createLocalVue } from '@vue/test-utils'
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'

import { capitalize, dateToString } from '@/utils/formatter'
import { getLinksInNav, createLink } from '@/utils/router'

const Function = {
    install(Vue) {
        Vue.prototype.$formatDate = dateObject => dateToString(dateObject)
        Vue.prototype.$createLink = createLink
        Vue.prototype.$getLinksInNav = getLinksInNav
    }
}

const localVue = createLocalVue()

localVue.use(VueRouter)
localVue.use(BootstrapVue)
localVue.use(BootstrapVueIcons)
localVue.filter('capitalize', capitalize);
localVue.use(Function)

/**
 * Export
 */
export { router, localVue }

