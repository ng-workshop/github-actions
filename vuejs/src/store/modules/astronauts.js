import astronautsClient from '@/api/astronauts'
import Astronaut from '@/props/astronaut'

export default {
    state: {
        items: [],
        errors: null,
    },
    mutations: {
        SAVE: (state, astronauts) => state.items = astronauts,
        SAVE_ERRORS: (state, errors) => state.errors = errors,
        CLEAR: state => state = Object.assign({}, state, {
            items: [],
            errors: null,
        })
    },
    actions: {
        LOAD: async ({ commit, dispatch }) => {
            dispatch('loader/ON_LOAD', null, { root: true })

            try {
                const jsonAstronauts = await astronautsClient.get()
                const astronauts = jsonAstronauts.map(json => Astronaut.fromJson(json))
                commit('SAVE', astronauts)
            } catch (error) {
                commit('SAVE_ERRORS', error.data)
            }

            dispatch('loader/IS_LOADED', null, { root: true })
        },
    },
    getters: {
        GET: state => state.items,
        HAS_ERRORS: state => null !== state.errors,
        GET_ERRORS: state => state.errors,
    },
    namespaced: true
}
