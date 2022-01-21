import Link from '@/props/link'

describe('Test "link" props', () => {
    test('Test create "link" from constructor', () => {
        const link = new Link({
            title: 'link',
            name: 'link',
            params: { id: 1 },
            query: { sort: 'asc' },
            meta: { nav: { display: true, position: 0 }},
        })

        expect(link.title).toBe('link')
        expect(link.name).toBe('link')
        expect(link.params.id).toBe(1)
        expect(link.query.sort).toBe('asc')
        expect(link.meta.nav.display).toBeTruthy()
        expect(link.meta.nav.position).toBe(0)
        expect(link.to).toMatchObject({
            name: 'link',
            params: { id: 1 },
            query: { sort: 'asc' },
            meta: { nav: { display: true, position: 0 }},
        })
    })

    test('Test create "link" from route', () => {
        const route = {
            name: 'route',
            params: { name: 'route' },
            query: { sort: 'desc' },
            meta: { title: 'route title', nav: { display: false, position: null } },
        }

        const link = Link.fromRoute(route)

        expect(link.title).toBe('route title')
        expect(link.name).toBe('route')
        expect(link.params.name).toBe('route')
        expect(link.query.sort).toBe('desc')
        expect(link.meta.nav.display).toBeFalsy()
        expect(link.meta.nav.position).toBeNull()
        expect(link.to).toMatchObject({
            name: 'route',
            params: { name: 'route' },
            query: { sort: 'desc' },
            meta: { title: 'route title', nav: { display: false, position: null } },
        })
    })
})
