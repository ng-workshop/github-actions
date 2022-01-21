import { mount } from '@vue/test-utils'
import { createLocalVue, createRouter } from '../../helpers'

import LinkTo from '@/components/Common/LinkTo'
import Link from '@/props/link'

describe('Test "LinkTo" components', () => {
    test('Test rendres to "LinkTo" components', () => {
        const link = new Link({ title: 'home', name: 'home' })
        const wrapper = mount(LinkTo, {
            localVue: createLocalVue({ withFilter: true, withRouter: true }),
            router: createRouter(),
            propsData: { link },
        })

        const routerLink = wrapper.findComponent({ name: 'router-link' })
        expect(routerLink.exists()).toBeTruthy()

        const spanElem = routerLink.find('span')
        expect(spanElem.exists()).toBeTruthy()
        expect(spanElem.text()).toBe('Home')

        expect(wrapper.vm.$children[0].$props.to).toBe(link.to)
    })
})
