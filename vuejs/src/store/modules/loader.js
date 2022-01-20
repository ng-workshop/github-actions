export default {
    state: {
        loading: false
    },
    mutations: {
        SET_STATE: (state, value) => state.loading = value,
    },
    actions: {
        ON_LOAD: ({ commit }) => commit('SET_STATE', true),
        IS_LOADED: ({ commit }) => commit('SET_STATE', false),
    },
    getters: {
        IS_LOADING: state => state.loading
    },
    namespaced: true,
}
