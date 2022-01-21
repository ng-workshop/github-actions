import { shallowMount } from '@vue/test-utils'
import {createLocalVue} from '../../helpers'

import ButtonIcon from '@/components/Common/ButtonIcon'
import Link from '@/props/link'

const createWrapper = (type = null) => shallowMount(ButtonIcon, {
    localVue: createLocalVue({ withBootstrap: true }),
    propsData: {
        link: new Link({ title: 'link', name: 'link' }),
        type,
    }
})

describe('Test "ButtonIcon" component', () => {
    test('Test "ButtonComponent" when type is "edit"', () => {
        const wrapper = createWrapper('edit')
        expect(wrapper.props('type')).toBe('edit')

        const bButton = wrapper.findComponent({ name: 'b-button' })
        expect(bButton.exists()).toBeTruthy()

        const icon = bButton.findComponent({ name: 'b-icon-pencil'})
        expect(icon.exists()).toBeTruthy()
    })

    test('Test "ButtonComponent" when type is "delete"', () => {
        const wrapper = createWrapper('delete')
        expect(wrapper.props('type')).toBe('delete')

        const bButton = wrapper.findComponent({ name: 'b-button' })
        expect(bButton.exists()).toBeTruthy()

        const icon = bButton.findComponent({ name: 'b-icon-trash'})
        expect(icon.exists()).toBeTruthy()
    })

    test('Test "ButtonComponent" when has no type', () => {
        const wrapper = createWrapper()
        expect(wrapper.props('type')).toBeNull()

        const bButton = wrapper.findComponent({ name: 'b-button' })
        expect(bButton.exists()).toBeTruthy()

        const icon = bButton.findComponent({ name: 'b-icon-blank'})
        expect(icon.exists()).toBeTruthy()
    })
})
