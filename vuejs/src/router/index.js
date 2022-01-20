import Vue from 'vue'
import VueRouter from 'vue-router'

import defaults from '@/router/defaults'
import astronauts from '@/router/astronauts'

Vue.use(VueRouter)

export const routes = [defaults, astronauts]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
