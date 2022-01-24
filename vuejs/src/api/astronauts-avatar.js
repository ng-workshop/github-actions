import axiosClient from './axios-client'
import ApiError from './error'

const BASE_PATH = '/astronauts/avatars'

export default {
    post: async data => {
        try {
            const response = await axiosClient.post(BASE_PATH, data)

            return response.data.filename
        } catch (error) {
            throw new ApiError(error.response)
        }
    },
    delete: async filename => {
        try {
            await axiosClient.delete(BASE_PATH + '/' + filename)
        } catch (error) {
            throw new ApiError(error.response)
        }
    }
}
