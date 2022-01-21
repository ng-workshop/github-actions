import { mount } from '@vue/test-utils'
import { createRouter, createLocalVue } from './helpers'

import App from '@/App'

describe('test "App"', () => {
    test('test render "App"', () => {
        const localVue = createLocalVue({
            withBootstrap: true,
            withFilter: true,
            withGlobalFunctions: true,
            withRouter: true,
        })
        const router = createRouter()

        const wrapper = mount(App, { localVue, router })

        expect(wrapper.findComponent({ name: 'nav-bar' }).exists()).toBeTruthy()
        expect(wrapper.find('#container').exists()).toBeTruthy()
        expect(wrapper.findComponent({ name: 'router-view' }).exists()).toBeTruthy()
    })
})
