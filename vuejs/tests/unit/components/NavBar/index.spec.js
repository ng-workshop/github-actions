import { shallowMount } from '@vue/test-utils'
import { createLocalVue } from '../../helpers'

import NavBar from '@/components/NavBar/Index'
import Link from '@/props/link'

describe('test "NavBar" component', () => {
    const link1 = new Link({ title: 'link 1', name: 'link-1' })
    const link2 = new Link({ title: 'link 2', name: 'link-2' })

    const wrapper = shallowMount(NavBar, {
        localVue: createLocalVue({ withBootstrap: true }),
        propsData: { links: [link1, link2] },
    })

    test('test render "NavBar" component', () => {
        const bNavBar = wrapper.findComponent({ name: 'b-navbar' })
        expect(bNavBar.exists()).toBeTruthy()

        const bNavbarBrand = bNavBar.findComponent({ name: 'b-navbar-brand' })
        expect(bNavbarBrand.exists()).toBeTruthy()
        expect(bNavbarBrand.text()).toBe('VueJS')

        const bNavbarToggle = bNavBar.findComponent({ name: 'b-navbar-toggle' })
        expect(bNavbarToggle.exists()).toBeTruthy()

        const bCollapse = bNavBar.findComponent({ name: 'b-collapse' })
        expect(bCollapse.exists()).toBeTruthy()

        const bNavbarNav = bCollapse.findComponent({ name: 'b-navbar-nav' })
        expect(bNavbarNav.exists()).toBeTruthy()

        const navBarItem = bCollapse.findAllComponents({ name: 'nav-bar-item' })
        expect(navBarItem).toHaveLength(2)

        const navBarItem1 = navBarItem.at(0)
        expect(navBarItem1.exists()).toBeTruthy()
        expect(navBarItem1.props('link')).toBe(link1)

        const navBarItem2 = navBarItem.at(1)
        expect(navBarItem2.exists()).toBeTruthy()
        expect(navBarItem2.props('link')).toBe(link2)
    })
})
