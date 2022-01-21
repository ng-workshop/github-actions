export const state = {
    loading: false
}

export const mutations = {
    SET_STATE: (state, value) => state.loading = value,
}

export const actions = {
    ON_LOAD: ({ commit }) => commit('SET_STATE', true),
    IS_LOADED: ({ commit }) => commit('SET_STATE', false),
}

export const getters = {
    IS_LOADING: () => state.loading
}

export default {
    state,
    mutations,
    actions,
    getters,
    namespaced: true,
}
