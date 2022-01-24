import axiosClient from '../../../src/api/axios-client'
import ApiError from '../../../src/api/error'
import astronautsClient from '../../../src/api/astronauts'

jest.mock('../../../src/api/axios-client')

describe('test "astronautsClient" module', () => {
    beforeEach(() => {
        jest.resetAllMocks();
    });

    describe('test "get" function', () => {
        test('test "get" function without id on success', async () => {
            const astronauts = [
                {
                    "id": 1,
                    "username": "wilson",
                    "planet": "hq",
                    "email": "wilson@eleven-labs.com",
                    "avatar": "http://cdn.workshop-ci.local/planets/hq.png",
                    "createdAt": {
                        "date": "2022-01-16 14:30:30.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    },
                    "updatedAt": {
                        "date": "2022-01-16 14:30:30.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    },
                    "formattedPlanetName": "hq"
                },
                {
                    "id": 2,
                    "username": "rocket raccoon",
                    "planet": "raccoons-of-asgard",
                    "email": "rocket-raccoon@eleven-labs.com",
                    "avatar": "http://cdn.workshop-ci.local/planets/raccoons-of-asgard.png",
                    "createdAt": {
                        "date": "2022-01-16 14:30:30.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    },
                    "updatedAt": {
                        "date": "2022-01-16 14:30:30.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    },
                    "formattedPlanetName": "Raccoons of asgard"
                }
            ]

            axiosClient.get.mockResolvedValueOnce({ data: astronauts });
            const data = await astronautsClient.get()
            expect(axiosClient.get).toHaveBeenCalledWith('/astronauts');
            expect(data).toEqual(astronauts)
        })

        test('test "get" function without id on error', async () => {
            const error = {
                data: { error: 'API ERROR'},
                statusCode: 500,
                statusText: 'Internal Server Error',
            }

            axiosClient.get.mockRejectedValue({ response: error });
            try {
                await astronautsClient.get()
            } catch (err) {
                expect(axiosClient.get).toHaveBeenCalledWith('/astronauts');
                expect(err).toEqual(new ApiError(error))
            }
        })

        test('test "get" function with id on success', async () => {
            const astronaut = {
                "id": 1,
                "username": "wilson",
                "planet": "hq",
                "email": "wilson@eleven-labs.com",
                "avatar": "http://cdn.workshop-ci.local/planets/hq.png",
                "createdAt": {
                    "date": "2022-01-16 14:30:30.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "updatedAt": {
                    "date": "2022-01-16 14:30:30.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "formattedPlanetName": "hq"
            }

            axiosClient.get.mockResolvedValueOnce({ data: astronaut });
            const data = await astronautsClient.get(1)
            expect(axiosClient.get).toHaveBeenCalledWith('/astronauts/1');
            expect(data).toEqual(astronaut)
        })

        test('test "get" function with id on error', async () => {
            const error = {
                data: { error: 'API ERROR'},
                statusCode: 500,
                statusText: 'Internal Server Error',
            }

            axiosClient.get.mockRejectedValue({ response: error });
            try {
                await astronautsClient.get(1)
            } catch (err) {
                expect(axiosClient.get).toHaveBeenCalledWith('/astronauts/1');
                expect(err).toEqual(new ApiError(error))
            }
        })
    })

    describe('test "post" function', () => {
        test('test "post" function on success', async () => {
            const postData = {
                username: "new astronaut",
                planet: "hq",
                email: "new-astronaut@eleven-labs.com",
                avatar: "tmp_file"
            }

            const astronaut = {
                "id": 6,
                "username": "new astronaut",
                "planet": "hq",
                "email": "new-astronaut@eleven-labs.com",
                "avatar": "http://cdn.workshop-ci.local/new-astronaut/avatar.png",
                "createdAt": {
                    "date": "2022-01-16 14:30:30.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "updatedAt": {
                    "date": "2022-01-16 14:30:30.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "formattedPlanetName": "hq"
            }

            axiosClient.post.mockResolvedValueOnce({ data: astronaut });
            const data = await astronautsClient.post(postData)
            expect(axiosClient.post).toHaveBeenCalledWith('/astronauts', postData);
            expect(data).toEqual(astronaut)
        })

        test('test "post" function on error', async () => {
            const postData = {
                username: "new astronaut",
                planet: "hq",
                email: "new-astronaut@eleven-labs.com",
                avatar: "tmp_file"
            }

            const error = {
                data: { error: 'API ERROR'},
                statusCode: 500,
                statusText: 'Internal Server Error',
            }

            axiosClient.post.mockRejectedValue({ response: error });
            try {
                await astronautsClient.post(postData)
            } catch (err) {
                expect(axiosClient.post).toHaveBeenCalledWith('/astronauts', postData);
                expect(err).toEqual(new ApiError(error))
            }
        })
    })

    describe('test "patch" function', () => {
        test('test "patch" function on success', async () => {
            const patchData = {
                username: "new astronaut name",
            }

            const astronaut = {
                "id": 6,
                "username": "new astronaut name",
                "planet": "hq",
                "email": "new-astronaut@eleven-labs.com",
                "avatar": "http://cdn.workshop-ci.local/new-astronaut-name/avatar.png",
                "createdAt": {
                    "date": "2022-01-16 14:30:30.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "updatedAt": {
                    "date": "2022-01-16 14:30:30.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "formattedPlanetName": "hq"
            }

            axiosClient.patch.mockResolvedValueOnce({ data: astronaut });
            const data = await astronautsClient.patch(6, patchData)
            expect(axiosClient.patch).toHaveBeenCalledWith('/astronauts/6', patchData);
            expect(data).toEqual(astronaut)
        })

        test('test "patch" function on error', async () => {
            const patchData = {
                username: "new astronaut name",
            }

            const error = {
                data: { error: 'API ERROR'},
                statusCode: 500,
                statusText: 'Internal Server Error',
            }

            axiosClient.patch.mockRejectedValue({ response: error });
            try {
                await astronautsClient.patch(6, patchData)
            } catch (err) {
                expect(axiosClient.patch).toHaveBeenCalledWith('/astronauts/6', patchData);
                expect(err).toEqual(new ApiError(error))
            }
        })
    })

    describe('test "put" function', () => {
        test('test "patch" function on success', async () => {
            const putData = {
                username: "new raccoon",
                planet: "raccoons-of-asgard",
                email: "new-raccoon@eleven-labs.com",
                avatar: "tmp_file"
            }

            const astronaut = {
                "id": 6,
                "username": "new raccoon",
                "planet": "raccoons-of-asgard",
                "email": "new-raccoon@eleven-labs.com",
                "avatar": "http://cdn.workshop-ci.local/new-raccoon/avatar.png",
                "createdAt": {
                    "date": "2022-01-16 14:30:30.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "updatedAt": {
                    "date": "2022-01-16 14:30:30.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "formattedPlanetName": "Raccoons Of Asgard"
            }

            axiosClient.put.mockResolvedValueOnce({ data: astronaut });
            const data = await astronautsClient.put(6, putData)
            expect(axiosClient.put).toHaveBeenCalledWith('/astronauts/6', putData);
            expect(data).toEqual(astronaut)
        })

        test('test "put" function on error', async () => {
            const putData = {
                username: "new raccoon",
                planet: "raccoons-of-asgard",
                email: "new-raccoon@eleven-labs.com",
                avatar: "tmp_file"
            }

            const error = {
                data: { error: 'API ERROR'},
                statusCode: 500,
                statusText: 'Internal Server Error',
            }

            axiosClient.put.mockRejectedValue({ response: error });
            try {
                await astronautsClient.put(6, putData)
            } catch (err) {
                expect(axiosClient.put).toHaveBeenCalledWith('/astronauts/6', putData);
                expect(err).toEqual(new ApiError(error))
            }
        })
    })

    describe('test "delete" function', () => {
        test('test "delete" function on success', async () => {
            axiosClient.delete.mockResolvedValueOnce('');
            const data = await astronautsClient.delete(1)
            expect(axiosClient.delete).toHaveBeenCalledWith('/astronauts/1');
            expect(data).toEqual(undefined)
        })

        test('test "delete" function on error', async () => {
            const error = {
                data: { error: 'API ERROR'},
                statusCode: 500,
                statusText: 'Internal Server Error',
            }

            axiosClient.delete.mockRejectedValue({ response: error });
            try {
                await astronautsClient.delete(1)
            } catch (err) {
                expect(axiosClient.delete).toHaveBeenCalledWith('/astronauts/1');
                expect(err).toEqual(new ApiError(error))
            }
        })
    })
})
