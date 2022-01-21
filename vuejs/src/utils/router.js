import { routes as routesFromRouter } from '@/router'
import Link from '@/props/link'

const navLinks = {}

export const getLinksInNav = () => Object.values(navLinks).length !== 0
    ? Object.values(navLinks)
    : Object.values(getLinksInNavByRoutes(routesFromRouter))

export const isLinkNav = route => 'meta' in route && 'nav' in route.meta && route.meta.nav.display === true

export const getLinksInNavByRoutes = routes => {
    for (const route of routes) {
        if ('children' in route) {
            getLinksInNavByRoutes(route.children)

            continue;
        }

        if (isLinkNav(route) && navLinks[route.meta.nav.position] === undefined) {
            navLinks[route.meta.nav.position] = routeToLink(route)
        }
    }

    return navLinks
}

export const routeToLink = (route) => Link.fromRoute(route)

export const getRouteByName = (name, routes = routesFromRouter) => {
    for (const route of routes) {
        if (route.name === name) {
            return route
        }

        if ('children' in route) {
            const matchedRoute = getRouteByName(name, route.children)

            if (matchedRoute !== undefined) {
                return matchedRoute
            }
        }
    }
}
