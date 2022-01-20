import { routes as routesFromRouter } from '@/router'
import Link from '@/props/link'

const navLinks = []

export const getLinksInNav = () => navLinks.length !== 0 ? navLinks : getLinksInNavByRoutes(routesFromRouter)
export const isLinkNav = route => 'meta' in route && 'inNav' in route.meta && route.meta.inNav === true

export const getLinksInNavByRoutes = routes => {
    for (const route of routes) {
        if ('children' in route) {
            getLinksInNavByRoutes(route.children)

            continue;
        }

        if (isLinkNav(route) && !navLinks.includes(route)) {
            navLinks.push(routeToLink(route))
        }
    }

    return navLinks
}

export const routeToLink = (route) => Link.fromRoute(route)
export const createLink = data => new Link(data)

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

export default { getLinksInNav, isLinkNav, getLinksInNavByRoutes, routeToLink, createLink }
