import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'

export const useBootstrap = localVue => {
    localVue.use(BootstrapVue)
    localVue.use(BootstrapVueIcons)
}
