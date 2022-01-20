import axiosClient from '@/api/axios-client'
import ApiError from '@/api/error'

const BASE_PATH = '/astronauts'
const PATH_WITH_ID = BASE_PATH + '/{id}'

export default {
    get: async (id = null) => {
        const url = null === id ? BASE_PATH : PATH_WITH_ID.replace('{id}', id);

        try {
            const response = await axiosClient.get(url)

            return response.data
        } catch (error) {
            throw new ApiError(error.response)
        }
    },
    post: async data => {
        delete data.id
        delete data.createdAt
        delete data.updatedAt

        try {
            const response = await axiosClient.post(BASE_PATH, data)

            return response.data
        } catch (error) {
            throw new ApiError(error.response)
        }
    },
    patch: async (id, data) => {
        try {
            const response = await axiosClient.patch(PATH_WITH_ID.replace('{id}', id), data)

            return response.data
        } catch (error) {
            throw new ApiError(error.response)
        }
    },
    put: async (id, data) => {
        try {
            const response = await axiosClient.put(PATH_WITH_ID.replace('{id}', id), data)

            return response.data
        } catch (error) {
            throw new ApiError(error.response)
        }
    },
    delete: async id => {
        try {
            await axiosClient.delete(PATH_WITH_ID.replace('{id}', id))
        } catch (error) {
            throw new ApiError(error.response)
        }
    }
}
