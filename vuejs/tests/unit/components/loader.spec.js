import { mount } from '@vue/test-utils'
import { localVue } from '../setup'

import Loader from '@/components/Loader'

describe('test "Loader" component', () => {
    test('test render "Loader" component', () => {
        const wrapper = mount(Loader, { localVue })

        expect(wrapper.find('strong').text()).toBe('Loading …')

        const bSpinner = wrapper.findComponent({ name: 'b-spinner' })
        expect(bSpinner.exists()).toBeTruthy()
    })
})
