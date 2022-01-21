import { state, mutations, actions, getters } from '@/store/modules/error'

const commit = (action, value) => {
    switch (action) {
        case 'RESET':
            mutations.RESET(state)

            return
        case 'ADD_ERROR':
            mutations.ADD_ERROR(state, value)

            return
        case 'ADD_ERRORS':
            mutations.ADD_ERRORS(state, value)

            return
    }
}

describe('Test "error" store', () => {
    afterAll(() => mutations.RESET())

    test('Test mutations "ADD_ERROR"', () => {
        expect(state.errors).toEqual([])
        expect(state.count).toEqual(0)

        mutations.ADD_ERROR(state, { message: 'message error 1'})

        expect(state.errors).toEqual([{ message: 'message error 1'}])
        expect(state.count).toEqual(1)
    })

    test('Test mutations "ADD_ERRORS"', () => {
        expect(state.errors).toEqual([{ message: 'message error 1'}])
        expect(state.count).toEqual(1)

        mutations.ADD_ERRORS(state, [
            { message: 'message error 2'},
            { message: 'message error 3'},
        ])

        expect(state.errors).toEqual([
            { message: 'message error 1'},
            { message: 'message error 2'},
            { message: 'message error 3'},
        ])
        expect(state.count).toEqual(3)
    })

    test('Test mutations "RESET"', () => {
        expect(state.errors).toEqual([
            { message: 'message error 1'},
            { message: 'message error 2'},
            { message: 'message error 3'},
        ])
        expect(state.count).toEqual(3)

        mutations.RESET(state)

        expect(state.errors).toEqual([])
        expect(state.count).toEqual(0)
    })

    test('Test "ADD" action with object', () => {
        expect(state.errors).toEqual([])
        expect(state.count).toEqual(0)

        actions.ADD({ commit }, { message: 'message error 1' })

        expect(state.errors).toEqual([{ message: 'message error 1'}])
        expect(state.count).toEqual(1)
    })

    test('Test "ADD" action with array', () => {
        expect(state.errors).toEqual([{ message: 'message error 1'}])
        expect(state.count).toEqual(1)

        actions.ADD({ commit }, [
            { message: 'message error 2' },
            { message: 'message error 3' },
        ])

        expect(state.errors).toEqual([
            { message: 'message error 1'},
            { message: 'message error 2'},
            { message: 'message error 3'},
        ])
        expect(state.count).toEqual(3)
    })

    test('Test "ADD" action with string', () => {
        expect(state.errors).toEqual([
            { message: 'message error 1'},
            { message: 'message error 2'},
            { message: 'message error 3'},
        ])
        expect(state.count).toEqual(3)

        actions.ADD({ commit }, 'message error 4')

        expect(state.errors).toEqual([
            { message: 'message error 1'},
            { message: 'message error 2'},
            { message: 'message error 3'},
            'message error 4'
        ])
        expect(state.count).toEqual(4)
    })

    test('Test "ADD" action with invalid error', () => {
        expect(state.errors).toEqual([
            { message: 'message error 1'},
            { message: 'message error 2'},
            { message: 'message error 3'},
            'message error 4',
        ])
        expect(state.count).toEqual(4)

        try {
            actions.ADD({ commit }, null)
        } catch (error) {
            expect(error.message).toBe('Error on add error in error store. Invalid value')
        }

        expect(state.errors).toEqual([
            { message: 'message error 1'},
            { message: 'message error 2'},
            { message: 'message error 3'},
            'message error 4',
        ])
        expect(state.count).toEqual(4)
    })

    test('Test "GET" getter', () => {
        expect(getters.GET()).toEqual([
            { message: 'message error 1'},
            { message: 'message error 2'},
            { message: 'message error 3'},
            'message error 4',
        ])
    })

    test('Test "COUNT" getter', () => {
        expect(getters.COUNT()).toEqual(4)
    })

    test('Test "CLEAR" action', () => {
        expect(state.errors).toEqual([
            { message: 'message error 1'},
            { message: 'message error 2'},
            { message: 'message error 3'},
            'message error 4',
        ])
        expect(state.count).toEqual(4)

        actions.CLEAR({ commit })

        expect(state.errors).toEqual([])
        expect(state.count).toEqual(0)
    })
})
