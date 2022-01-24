import {createLocalVue as testUtilsCreateLocalVue} from "@vue/test-utils";

import { useBootstrap, useFilters, useGlobalFunctions, useRouter } from './index'

export const createLocalVue = ({
   withBootstrap = false,
   withFilter = false,
   withGlobalFunctions = false,
   withRouter = false,
}) => {
    const localVue = testUtilsCreateLocalVue()

    if (withBootstrap) useBootstrap(localVue)
    if (withFilter) useFilters(localVue)
    if (withGlobalFunctions) useGlobalFunctions(localVue)
    if (withRouter) useRouter(localVue)

    return localVue
}
