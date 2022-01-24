import VueRouter from 'vue-router'

import router from '../../../src/router'

export const createRouter = () => router

export const useRouter = localVue => localVue.use(VueRouter)
