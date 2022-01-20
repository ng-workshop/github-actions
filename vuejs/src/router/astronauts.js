export default {
    path: '/astronauts',
    name: 'astronauts',
    component: () => import(/* webpackChunkName: "astronaut" */ '@/views/Astronauts/Default.vue'),
    children: [
        {
            path: 'delete/:id',
            name: 'astronauts-delete',
            component: () => import(/* webpackChunkName: "astronaut" */ '@/views/Astronauts/Delete.vue'),
            meta: {
                title: 'astronaut delete',
                inNav: false,
            },
        },
        {
            path: 'edit/:id',
            name: 'astronauts-edit',
            component: () => import(/* webpackChunkName: "astronaut" */ '@/views/Astronauts/Edit.vue'),
            meta: {
                title: 'astronaut delete',
                inNav: false,
            },
        },
        {
            path: 'list',
            name: 'astronauts-list',
            component: () => import(/* webpackChunkName: "astronauts" */ '@/views/Astronauts/List.vue'),
            meta: {
                title: 'astronaut list',
                inNav: true,
            },
        },
        {
            path: 'new',
            name: 'astronauts-new',
            component: () => import(/* webpackChunkName: "astronaut" */ '@/views/Astronauts/New.vue'),
            meta: {
                title: 'astronaut delete',
                inNav: false,
            },
        },
        {
            path: 'show/:id',
            name: 'astronauts-show',
            component: () => import(/* webpackChunkName: "astronaut" */ '@/views/Astronauts/Show.vue'),
            meta: {
                title: 'astronaut delete',
                inNav: false,
            },
        }
    ],
}
