import { mount } from '@vue/test-utils'
import { router, localVue } from './setup'

import App from '@/App'

describe('test "App"', () => {
    test('test render "App"', () => {
        const wrapper = mount(App, { router, localVue })

        expect(wrapper.findComponent({ name: 'nav-bar' }).exists()).toBeTruthy()
        expect(wrapper.find('#container').exists()).toBeTruthy()
        expect(wrapper.findComponent({ name: 'router-view' }).exists()).toBeTruthy()
    })
})
