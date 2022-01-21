import { state, mutations, actions, getters } from '@/store/modules/loader'

describe('Test "loader" store', () => {
    test('Test mutations "SET_STATE"', () => {
        expect(state.loading).toBeFalsy()

        mutations.SET_STATE(state, true)

        expect(state.loading).toBeTruthy()

        mutations.SET_STATE(state, false)

        expect(state.loading).toBeFalsy()
    })

    test('Test "ON_LOAD" action', () => {
        const commit = () => {
            mutations.SET_STATE(state, true)
        }

        expect(state.loading).toBeFalsy()

        actions.ON_LOAD({ commit })

        expect(state.loading).toBeTruthy()
    })

    test('Test "IS_LOADED" action', () => {
        const commit = () => {
            mutations.SET_STATE(state, false)
        }

        expect(state.loading).toBeTruthy()

        actions.IS_LOADED({ commit })

        expect(state.loading).toBeFalsy()
    })

    test('Test "IS_LOADING" getter', () => {
        expect(getters.IS_LOADING()).toBeFalsy()
    })
})
