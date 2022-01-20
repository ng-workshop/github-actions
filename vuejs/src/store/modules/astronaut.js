import astronautClient from '@/api/astronauts'

export default {
    state: {
        item: {
            id: null,
            username: null,
            planet: null,
            formattedPlanetName: null,
            email: null,
            avatar: null,
            createdAt: null,
            updatedAt: null,
        },
        loading: false,
        errors: null,
    },
    mutations: {
        SAVE: (state, astronaut) => state.item = astronaut,
        ON_LOAD: state => state.loading = true,
        LOADED: state => state.loading = false,
        SAVE_ERRORS: (state, errors) => state.errors = errors,
        CLEAR: state => Object.assign(state, {
            item: {
                id: null,
                username: null,
                planet: null,
                formattedPlanetName: null,
                email: null,
                avatar: null,
                createdAt: null,
                updatedAt: null,
            },
            loading: false,
            errors: null,
        }),
    },
    actions: {
        LOAD: async ({ commit, state }, id) => {
            if (state.item.id === id) {
                return
            }

            commit('ON_LOAD')

            try {
                commit('SAVE', await astronautClient.get(id))
            } catch (error) {
                commit('SAVE_ERRORS', error.data)
            }

            commit('LOADED')
        },
        SAVE: async({ commit }, astronaut) => {
            commit('ON_LOAD')

            try {
                commit('SAVE', await astronautClient.post(astronaut))
            } catch (error) {
                commit('SAVE_ERRORS', error.data)
            }

            commit('LOADED')
        }
    },
    getters: {
        GET: state => state.item,
        IS_LOADING: state => state.loading,
        HAS_ERRORS: state => null !== state.errors,
        GET_ERRORS: state => state.errors,
    },
    namespaced: true
}
