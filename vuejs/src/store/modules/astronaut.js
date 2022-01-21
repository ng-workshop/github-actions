import astronautClient from '@/api/astronauts'

export const state = {
    id: null,
    username: null,
    planet: null,
    formattedPlanetName: null,
    email: null,
    avatar: null,
    createdAt: null,
    updatedAt: null,
}

export const mutations = {
    SAVE: (state, astronaut) => Object.assign({}, state, astronaut),
    CLEAR: state => Object.assign(state, {
        id: null,
        username: null,
        planet: null,
        formattedPlanetName: null,
        email: null,
        avatar: null,
        createdAt: null,
        updatedAt: null,
    }),
}

export const actions = {
    LOAD: async ({ commit, state, dispatch }, id) => {
        if (state.item.id === id) {
            return
        }

        dispatch('loader/ON_LOAD', null, { root: true })

        try {
            commit('SAVE', await astronautClient.get(id))
        } catch (error) {
            dispatch('error/ADD', error.data, { root: true })
        }

        dispatch('loader/IS_LOADED', null, { root: true })
    },
    SAVE: async({ commit, dispatch }, astronaut) => {
        dispatch('loader/ON_LOAD', null, { root: true })

        try {
            commit('SAVE', await astronautClient.post(astronaut))
        } catch (error) {
            dispatch('error/ADD', error.data, { root: true })
        }

        dispatch('loader/IS_LOADED', null, { root: true })
    }
}

export const getters = {
    GET: state => state.item,
}

export default {
    state,
    mutations,
    actions,
    getters,
    namespaced: true
}
