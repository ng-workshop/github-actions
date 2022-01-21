import Astronaut from '@/props/astronaut'
import Link from '@/props/link'

describe('Test "astronaut" props', () => {
    test('Test create "astronauts" from constructor', () => {
        const astronaut = new Astronaut({
            id: 1,
            username: 'wilson',
            planet: 'hq',
            formattedPlanetName: 'HQ',
            avatar: 'https://cdn.test/planets/hq.png',
            links: {
                show: new Link({ title: 1, name: 'show'}),
                edit: new Link({ title: 1, name: 'edit'}),
                delete: new Link({ title: 1, name: 'delete'}),
            },
            createdAt: {
                date: "2022-01-16 14:30:30.000000",
                timezone_type: 3,
                timezone: "UTC"
            },
            updatedAt: {
                date: "2022-01-16 14:30:30.000000",
                timezone_type: 3,
                timezone: "UTC"
            },
        })

        expect(astronaut.id).toBe(1)
        expect(astronaut.username).toBe('wilson')
        expect(astronaut.planet).toBe('hq')
        expect(astronaut.formattedPlanetName).toBe('HQ')
        expect(astronaut.avatar).toBe('https://cdn.test/planets/hq.png')
        expect(astronaut.links).toHaveProperty('show')
        expect(astronaut.links).toHaveProperty('edit')
        expect(astronaut.links).toHaveProperty('delete')
        expect(astronaut.createdAt.date).toBe("2022-01-16 14:30:30.000000")
        expect(astronaut.updatedAt.date).toBe("2022-01-16 14:30:30.000000")
    })

    test('Test create "astronauts" from constructor with null property', () => {
        const astronaut = new Astronaut({
            username: 'wilson',
            planet: 'hq',
            formattedPlanetName: 'HQ',
            avatar: 'https://cdn.test/planets/hq.png',
            links: {
                show: new Link({ title: 1, name: 'show'}),
                edit: new Link({ title: 1, name: 'edit'}),
                delete: new Link({ title: 1, name: 'delete'}),
            },
        })

        expect(astronaut.id).toBeNull()
        expect(astronaut.username).toBe('wilson')
        expect(astronaut.createdAt).toBeNull()
        expect(astronaut.updatedAt).toBeNull()
    })

    test('Test create "astronauts" from json', () => {
        const astronaut = Astronaut.fromJson({
            id: 2,
            username: 'rocket raccoon',
            planet: 'raccoons-of-asgard',
            formattedPlanetName: 'Racoons Of Asgard',
            avatar: 'https://cdn.test/astronauts/rocket-raccoon.png',
            createdAt: {
                date: "2022-01-18 14:30:30.000000",
                timezone_type: 3,
                timezone: "UTC"
            },
            updatedAt: {
                date: "2022-01-18 14:30:30.000000",
                timezone_type: 3,
                timezone: "UTC"
            }
        })

        expect(astronaut.id).toBe(2)
        expect(astronaut.username).toBe('rocket raccoon')
        expect(astronaut.planet).toBe('raccoons-of-asgard')
        expect(astronaut.formattedPlanetName).toBe('Racoons Of Asgard')
        expect(astronaut.avatar).toBe('https://cdn.test/astronauts/rocket-raccoon.png')
        expect(astronaut.links).toHaveProperty('show')
        expect(astronaut.links).toHaveProperty('edit')
        expect(astronaut.links).toHaveProperty('delete')

        expect(astronaut.links.show.title).toBe(2)
        expect(astronaut.links.show.params.id).toBe(2)
        expect(astronaut.links.show.name).toBe('astronauts-show')

        expect(astronaut.links.edit.title).toBe(2)
        expect(astronaut.links.edit.params.id).toBe(2)
        expect(astronaut.links.edit.name).toBe('astronauts-edit')

        expect(astronaut.links.delete.title).toBe(2)
        expect(astronaut.links.delete.params.id).toBe(2)
        expect(astronaut.links.delete.name).toBe('astronauts-delete')

        expect(astronaut.createdAt.date).toBe("2022-01-18 14:30:30.000000")
        expect(astronaut.updatedAt.date).toBe("2022-01-18 14:30:30.000000")

    })
})
