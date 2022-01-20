export default {
    path: '/',
    component: () => import(/* webpackChunkName: "astronaut" */ '@/views/Default.vue'),
    children: [
        {
            path: '',
            name: 'home',
            component: () => import(/* webpackChunkName: "home" */ '@/views/Home.vue'),
            meta: {
                title: 'home',
                inNav: true,
            }
        }
    ]
}
