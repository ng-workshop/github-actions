export const state = {
    errors: [],
    count: 0,
}

export const mutations = {
    RESET: state => {
        state.errors = []
        state.count = 0
    },
    ADD_ERROR: (state, error) => {
        state.errors.push(error)
        state.count = state.errors.length
    },
    ADD_ERRORS: (state, errors) => {
        state.errors = state.errors.concat(errors)
        state.count = state.errors.length
    },
}

export const actions = {
    ADD: ({ commit }, value) => {
        if (Array.isArray(value) || typeof value === 'string') {
            commit('ADD_ERRORS', value)

            return
        }

        if (typeof value === 'object' && value !== null) {
            commit('ADD_ERROR', value)

            return
        }

        throw Error('Error on add error in error store. Invalid value')
    },
    CLEAR: ({ commit }) => commit('RESET'),
}

export const getters = {
    GET: () => state.errors,
    COUNT: () => state.count,
    HAS: () => state.count !== 0,
}

export default {
    state,
    mutations,
    actions,
    getters,
    namespaced: true,
}
