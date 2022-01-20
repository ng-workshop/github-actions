const IMAGE_FORMAT_LANDSCAPE = 'landscape'
const IMAGE_FORMAT_PORTRAIT = 'portrait'
const IMAGE_FORMAT_SQUARE = 'square'

export const getImageFormat = (width, height) => {
    return width === height ? IMAGE_FORMAT_SQUARE : width > height ? IMAGE_FORMAT_LANDSCAPE : IMAGE_FORMAT_PORTRAIT
}

export const fileToBase64 = file => {
    return new Promise((resolve, reject) => {
        const reader = new FileReader()
        reader.onerror = () => reject(new Error ('Error on load file'))
        reader.onload = event => resolve(event.target.result)
        reader.readAsDataURL(file)
    })
}

export const getImageMetadata = async file => {
    const URL = window.URL || window.webkitURL

    return new Promise((resolve, reject) => {
        const image = new Image()
        image.onerror = () => reject(new Error('Error on create Image object'));
        image.onload = () => resolve({
            width: image.width,
            height: image.height,
            format: getImageFormat(image.width, image.height)
        })
        image.src = URL.createObjectURL(file)
    })
}

export const getAuthorizedImageFormat = () => {
    return [IMAGE_FORMAT_LANDSCAPE, IMAGE_FORMAT_PORTRAIT, IMAGE_FORMAT_SQUARE]
}

export default { getImageFormat, fileToBase64, getImageMetadata, getAuthorizedImageFormat }
