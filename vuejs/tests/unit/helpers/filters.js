import { capitalize } from '@/utils/formatter'

export const useFilters = localVue => {
    localVue.filter('capitalize', capitalize);
}
