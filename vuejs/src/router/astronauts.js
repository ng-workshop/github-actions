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
                nav: {
                    display: false,
                    position: null,
                },
            },
        },
        {
            path: 'edit/:id',
            name: 'astronauts-edit',
            component: () => import(/* webpackChunkName: "astronaut" */ '@/views/Astronauts/Edit.vue'),
            meta: {
                title: 'astronaut delete',
                nav: {
                    display: false,
                    position: null,
                },
            },
        },
        {
            path: 'list',
            name: 'astronauts-list',
            component: () => import(/* webpackChunkName: "astronauts" */ '@/views/Astronauts/List.vue'),
            meta: {
                title: 'astronaut list',
                nav: {
                    display: true,
                    position: 100,
                },
            },
        },
        {
            path: 'new',
            name: 'astronauts-new',
            component: () => import(/* webpackChunkName: "astronaut" */ '@/views/Astronauts/New.vue'),
            meta: {
                title: 'astronaut delete',
                nav: {
                    display: false,
                    position: null,
                },
            },
        },
        {
            path: 'show/:id',
            name: 'astronauts-show',
            component: () => import(/* webpackChunkName: "astronaut" */ '@/views/Astronauts/Show.vue'),
            meta: {
                title: 'astronaut delete',
                nav: {
                    display: false,
                    position: null,
                },
            },
        }
    ],
}
