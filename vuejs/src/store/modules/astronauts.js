import astronautsClient from '@/api/astronauts'
import Astronaut from '@/props/astronaut'

export const state = {
    items: [],
}

export const mutations = {
    SAVE: (state, astronauts) => state.items = astronauts,
    CLEAR: state => state.items = [],
}

export const actions = {
    LOAD: async ({ commit, dispatch }) => {
        dispatch('loader/ON_LOAD', null, { root: true })

        try {
            const jsonAstronauts = await astronautsClient.get()
            const astronauts = jsonAstronauts.map(json => Astronaut.fromJson(json))
            commit('SAVE', astronauts)
        } catch (error) {
            dispatch('error/ADD', error.data, { root: true })
        }

        dispatch('loader/IS_LOADED', null, { root: true })
    },
}

export const getters = {
    GET: state => state.items,
    HAS_ERRORS: state => null !== state.errors,
    GET_ERRORS: state => state.errors,
}

export default {
    state,
    mutations,
    actions,
    getters,
    namespaced: true
}
