import VueRouter from 'vue-router'

import routeDefaults from '@/router/defaults'
import routeAstronauts from '@/router/astronauts'

export const createRouter = () => {
    return new VueRouter({
        mode: 'history',
        base: process.env.BASE_URL,
        routes: [routeDefaults, routeAstronauts],
    })
}

export const useRouter = localVue => localVue.use(VueRouter)
