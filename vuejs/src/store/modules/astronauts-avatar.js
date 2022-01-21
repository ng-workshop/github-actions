import astronautAvatarClient from '@/api/astronauts-avatar'
import { fileToBase64 } from '@/utils/file'

export const state = {
    tmpFilename: null,
    tmpFileBase64Encoded: null,
}


export const mutations = {
    SAVE: (state, { tmpFilename, tmpFileBase64Encoded }) => {
        state.tmpFilename = tmpFilename
        state.tmpFileBase64Encoded = tmpFileBase64Encoded
    },
    REMOVE: state => {
        state.tmpFilename = null
        state.tmpFileBase64Encoded = null
    },
    CLEAR: state => Object.assign(state, {
        tmpFilename: null,
        tmpFileBase64Encoded: null,
    })
}

export const actions = {
    UPLOAD: async ({ commit, state, dispatch }, file) => {
        dispatch('loader/ON_LOAD', null, { root: true })

        try {
            if (null !== state.tmpFilename) {
                await astronautAvatarClient.delete(state.tmpFilename)

                commit('REMOVE')
            }

            const tmpFileBase64Encoded = await fileToBase64(file)
            const tmpFilename = await astronautAvatarClient.post({ file: tmpFileBase64Encoded })

            commit('SAVE', { tmpFilename, tmpFileBase64Encoded })

        } catch (error) {
            dispatch('error/ADD', error.data, { root: true })
        }

        dispatch('loader/IS_LOADED', null, { root: true })
    },
}

export const getters = {
    GET_FILE_NAME: state => state.tmpFilename,
    GET_BASE64_ENCODED: state => state.tmpFileBase64Encoded,
}

export default {
    state,
    mutations,
    actions,
    getters,
    namespaced: true,
}
