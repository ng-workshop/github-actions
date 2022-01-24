import axiosClient from '../../../src/api/axios-client'
import ApiError from '../../../src/api/error'
import astronautsAvatarClient from '../../../src/api/astronauts-avatar'

jest.mock('../../../src/api/axios-client')

describe('test "astronautsAvatarClient" module', () => {
    beforeEach(() => {
        jest.resetAllMocks();
    });

    describe('test "post" function', () => {
        test('test "post" function on success', async () => {
            axiosClient.post.mockResolvedValueOnce({ data: { filename: 'filename.ext' } });

            const data = await astronautsAvatarClient.post({ 'file': 'base64encodedFile' })

            expect(axiosClient.post).toHaveBeenCalledWith('/astronauts/avatars', { file: 'base64encodedFile' });
            expect(data).toEqual('filename.ext')
        })

        test('test "post" function on error', async () => {
            const error = {
                data: { error: 'API ERROR'},
                statusCode: 500,
                statusText: 'Internal Server Error',
            }

            axiosClient.post.mockRejectedValue({ response: error });
            try {
                await astronautsAvatarClient.post({ 'file': 'base64encodedFile' })
            } catch (err) {
                expect(axiosClient.post).toHaveBeenCalledWith('/astronauts/avatars', { file: 'base64encodedFile' });
                expect(err).toEqual(new ApiError(error))
            }
        })
    })

    describe('test "delete" function', () => {
        test('test "delete" function on success', async () => {
            axiosClient.delete.mockResolvedValueOnce();

            const data = await astronautsAvatarClient.delete('filename.ext')

            expect(axiosClient.delete).toHaveBeenCalledWith('/astronauts/avatars/filename.ext');
            expect(data).toEqual(undefined)
        })

        test('test "delete" function on success', async () => {
            const error = {
                data: { error: 'API ERROR'},
                statusCode: 500,
                statusText: 'Internal Server Error',
            }

            axiosClient.delete.mockRejectedValue({ response: error });
            try {
                await astronautsAvatarClient.delete('filename.ext')
            } catch (err) {
                expect(axiosClient.delete).toHaveBeenCalledWith('/astronauts/avatars/filename.ext');
                expect(err).toEqual(new ApiError(error))
            }
        })
    })
})
