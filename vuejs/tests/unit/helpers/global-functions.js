import { dateToString } from '@/utils/formatter'
import { getLinksInNav } from '@/utils/router'

export const useGlobalFunctions = localVue => localVue.use({
    install(Vue) {
        Vue.prototype.$formatDate = dateObject => dateToString(dateObject)
        Vue.prototype.$getLinksInNav = getLinksInNav
    }
})
