import Vue from 'vue'

import { dateToString, getLinksInNav } from "../utils"

const Function = {
    install(Vue) {
        Vue.prototype.$formatDate = dateObject => dateToString(dateObject)
        Vue.prototype.$getLinksInNav = getLinksInNav
    }
}

Vue.use(Function)
