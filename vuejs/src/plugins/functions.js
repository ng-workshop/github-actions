import Vue from 'vue'

import { dateToString } from "@/utils/formatter"
import { getLinksInNav, createLink } from '@/utils/router'

const Function = {
    install(Vue) {
        Vue.prototype.$formatDate = dateObject => dateToString(dateObject)
        Vue.prototype.$createLink = createLink
        Vue.prototype.$getLinksInNav = getLinksInNav
    }
}

Vue.use(Function)
