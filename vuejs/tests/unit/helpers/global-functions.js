import { dateToString, getLinksInNav } from '../../../src/utils'

export const useGlobalFunctions = localVue => localVue.use({
    install(Vue) {
        Vue.prototype.$formatDate = dateObject => dateToString(dateObject)
        Vue.prototype.$getLinksInNav = getLinksInNav
    }
})
