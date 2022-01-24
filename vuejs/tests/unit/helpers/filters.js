import { capitalize } from '../../../src/utils'

export const useFilters = localVue => {
    localVue.filter('capitalize', capitalize);
}
