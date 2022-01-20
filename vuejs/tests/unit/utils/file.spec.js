import { getImageFormat, fileToBase64, getImageMetadata, getAuthorizedImageFormat } from '@/utils/file'

describe('test package "file"', () => {
    const file = new File(['A test file'], "test.txt", { type: "text/plain" })

    describe('test "getImageFormat" function', () => {
        test('test that for an image of 150px by 100px the function returns "landscape"', () => {
            expect(getImageFormat(150, 100)).toEqual('landscape')
        })

        test('test that for an image of 100px by 150px the function returns "portrait"', () => {
            expect(getImageFormat(100, 150)).toEqual('portrait')
        })

        test('test that for an image of 100px by 100px the function returns "square"', () => {
            expect(getImageFormat(100, 100)).toEqual('square')
        })
    })

    describe('test "fileToBase64" function', () => {
        test('test to convert file to base64', async () => {
            await expect(fileToBase64(file)).resolves.toEqual('data:text/plain;charset=undefined,A%20test%20file')
        })

        test('test to convert file in base64 when invalid parameter', async () => {
            try {
                await fileToBase64('')
            } catch (err) {
                expect(err.message).toEqual("Failed to execute 'readAsDataURL' on 'FileReader': parameter 1 is not of type 'Blob'.")
            }
        })

        test('test to convert file in base64 on error', async () => {
            global.FileReader = class {
                readAsDataURL() {
                    setTimeout(() => {
                        this.onerror();
                    }, 10);
                }
            }

            try {
                await fileToBase64(file)
            } catch (err) {
                expect(err.message).toEqual("Error on load file")
            }
        })
    })

    describe('test "getImageMetadata" function', () => {
        test('test to get metadata to file (URL)', async () => {
            global.Image = class {
                constructor() {
                    this.width = 100
                    this.height = 100
                    setTimeout(() => {
                        this.onload();
                    }, 10);
                }
            }
            global.URL.createObjectURL = jest.fn()

            const imageMetadata = await getImageMetadata(file)
            expect(imageMetadata).toEqual({ width: 100, height: 100, format: 'square' })
        })


        test('test to get metadata to file on error (webkitURL)', async () => {
            global.Image = class {
                constructor() {
                    setTimeout(() => {
                        this.onerror();
                    }, 10);
                }
            }
            global.URL = null
            global.webkitURL = {}
            global.webkitURL.createObjectURL = jest.fn()

            try {
                await getImageMetadata(file)
            } catch (err) {
                expect(err.message).toEqual('Error on create Image object')
            }
        })
    })

    describe('test "getAuthorizedImageFormat" function', () => {
        test('test the return of the "getAuthorizedImageFormat" function', () => {
            expect(getAuthorizedImageFormat()).toEqual(['landscape', 'portrait', 'square'])
        })
    })
})
