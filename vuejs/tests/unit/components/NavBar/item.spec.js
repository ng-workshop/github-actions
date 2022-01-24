import { mount } from '@vue/test-utils'
import VueRouter from 'vue-router'

import { createLocalVue } from '../../helpers'

import NavBarItem from '../../../../src/components/NavBar/Item'
import { Link } from '../../../../src/props'

describe('test "NavBarItem" component', () => {
    const link = new Link({ title: 'link 1', name: 'link-1' })
    const router = new VueRouter({
        mode: 'history',
        base: process.env.BASE_URL,
        routes: [
            {
                path: '/route-1',
                name: 'link-1'
            },
            {
                path: '/route-2',
                name: 'link-2'
            }
        ],
    })
    const wrapper = mount(NavBarItem, {
        localVue: createLocalVue({ withBootstrap: true, withFilter: true }),
        router,
        propsData: { link: link }
    })
    const bNavItem = wrapper.getComponent({ name: 'b-nav-item' })
    expect(wrapper.props('link')).toBe(link)
    expect(bNavItem.exists()).toBeTruthy()
    expect(bNavItem.text()).toBe('Link 1')
    expect(wrapper.vm.$children[0].$props.to).toBe(link.to)

    test('test render "NavBarItem" component if is active route', async () => {
        await router.push({ name: 'link-1'})
        expect(wrapper.vm.$children[0].$props.active).toBeTruthy()
    })

    test('test render "NavBarItem" component if is inactive route', async () => {
        await router.push({ name: 'link-2'})
        expect(wrapper.vm.$children[0].$props.active).toBeFalsy()
    })
})
