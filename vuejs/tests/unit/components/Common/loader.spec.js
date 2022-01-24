import { shallowMount } from '@vue/test-utils'
import { createLocalVue } from '../../helpers'

import Loader from '../../../../src/components/Common/Loader'

describe('test "Loader" component', () => {
    test('test render "Loader" component', () => {
        const wrapper = shallowMount(Loader, {
            localVue: createLocalVue({ withBootstrap: true })
        })

        expect(wrapper.find('strong').text()).toBe('Loading …')

        const bSpinner = wrapper.findComponent({ name: 'b-spinner' })
        expect(bSpinner.exists()).toBeTruthy()
    })
})
