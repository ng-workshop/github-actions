import { extend } from 'vee-validate'

import { email, ext, image, max, mimes, min, required, size } from 'vee-validate/dist/rules'
import { imageFormat, imageMaxHeight, imageMaxWith, imageMinHeight, imageMinWith } from './image'
import {
    email as emailOverwrite,
    max as maxOverwrite,
    min as minOverwrite,
    required as requiredOverwrite
} from './overwrite'
import { planetChoices } from './planet'

/**
 * Import default rules and overwrite
 */
extend('email', { ...email, ...emailOverwrite });
extend('ext', {...ext})
extend('image', {...image})
extend('max', { ...max, ...maxOverwrite });
extend('mimes', {...mimes})
extend('min', { ...min, ...minOverwrite });
extend('required', { ...required, ...requiredOverwrite });
extend('size', {...size})

/**
 * Custom rules
 */
extend('imageFormat', imageFormat)
extend('imageMaxHeight', imageMaxHeight)
extend('imageMaxWith', imageMaxWith)
extend('imageMinHeight', imageMinHeight)
extend('imageMinWith', imageMinWith)
extend('planetChoice', planetChoices)




