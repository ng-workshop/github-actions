import { getAuthorizedImageFormat, getImageMetadata } from '../utils/file';
import { capitalize } from '../utils/formatter'

const imageFormat = {
    params: [{ name: 'formats', default: ['all'] }],
    validate: async (file, { formats }) => {
        const unauthorizedFormats = formats.filter(x => !getAuthorizedImageFormat().includes(x))

        if (0 !== unauthorizedFormats.length) {
            throw new Error(
                `Invalid format at "imageFormat" validator. Authorized format: ${getAuthorizedImageFormat().join(', ')}.`
                + ` Current formats: ${unauthorizedFormats.join(', ')}.`
            )
        }


        const imageMetadata = await getImageMetadata(file)

        return !formats.includes(imageMetadata.format)
            ? `${capitalize(imageMetadata.format)} oriented images are not allowed`
            : true
    }
}

const imageMaxHeight = {
    params: [{ name: 'maxHeight', default: 256 }],
    validate: async (file, { maxHeight }) => {
        const imageMetadata = await getImageMetadata(file)

        return imageMetadata.height > 256
            ? `The avatar height is too big (${imageMetadata.height}px). Allowed maximum height is ${maxHeight}px.`
            : true
    },
}

const imageMaxWith = {
    params: [{ name: 'maxWith', default: 256 }],
    validate: async (file, { maxWith }) => {
        const imageMetadata = await getImageMetadata(file)

        return imageMetadata.width > maxWith
            ? `The avatar width is too big (${imageMetadata.width}px). Allowed maximum width is ${maxWith}px.`
            : true
    },
}

const imageMinHeight = {
    params: [{ name: 'minHeight', default: 64 }],
    validate: async (file, { minHeight }) => {
        const imageMetadata = await getImageMetadata(file)

        return imageMetadata.height < minHeight
            ? `The avatar height is too small (${imageMetadata.height}px). Minimum height expected is ${minHeight}px.`
            : true
    },
}

const imageMinWith = {
    params: [{ name: 'minWith', default: 64 }],
    validate: async (file, { minWith }) => {
        const imageMetadata = await getImageMetadata(file)

        return imageMetadata.width < minWith
            ? `The avatar width is too small (${imageMetadata.width}px). Minimum width expected is ${minWith}px.`
            : true
    },
}

export { imageFormat, imageMaxHeight, imageMaxWith, imageMinHeight, imageMinWith }
