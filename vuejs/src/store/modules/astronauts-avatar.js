import astronautAvatarClient from '@/api/astronauts-avatar'
import { fileToBase64 } from '@/utils/file'

export default {
    state: {
        tmpFilename: null,
        tmpFileBase64Encoded: null,
        loading: false,
        errors: null,
    },
    mutations: {
        SAVE: (state, { tmpFilename, tmpFileBase64Encoded }) => {
            state.tmpFilename = tmpFilename
            state.tmpFileBase64Encoded = tmpFileBase64Encoded
        },
        REMOVE: state => {
            state.tmpFilename = null
            state.tmpFileBase64Encoded = null
        },
        ON_LOAD: state => state.loading = true,
        LOADED: state => state.loading = false,
        SAVE_ERRORS: (state, errors) => state.errors = errors,
        CLEAR: state => state = Object.assign({}, state, {
            tmpFilename: null,
            tmpFileBase64Encoded: null,
            loading: false,
            errors: null,
        })
    },
    actions: {
        UPLOAD: async ({ commit, state}, file) => {
            commit('ON_LOAD')

            try {
                if (null !== state.tmpFilename) {
                    await astronautAvatarClient.delete(state.tmpFilename)
                    commit('REMOVE')
                }

                const tmpFileBase64Encoded = await fileToBase64(file)
                const tmpFilename = await astronautAvatarClient.post({ file: tmpFileBase64Encoded })
                commit('SAVE', { tmpFilename, tmpFileBase64Encoded })

            } catch (error) {
                commit('SAVE_ERRORS', error.data)
            }

            commit('LOADED')
        },
    },
    getters: {
        GET_FILE_NAME: state => state.tmpFilename,
        GET_BASE64_ENCODED: state => state.tmpFileBase64Encoded,
        IS_LOADING: state => state.loading,
        HAS_ERRORS: state => null !== state.errors,
        GET_ERRORS: state => state.errors,
    },
    namespaced: true,
}
