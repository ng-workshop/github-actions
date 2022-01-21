import Link from '@/props/link'
import { getRouteByName } from '@/utils/router'

export default class {
    constructor({
        id = null,
        username,
        planet,
        formattedPlanetName,
        avatar,
        links,
        createdAt = null,
        updatedAt = null
    }) {
        this.id = id
        this.username = username
        this.planet = planet
        this.formattedPlanetName = formattedPlanetName
        this.avatar = avatar
        this.links = links
        this.createdAt = createdAt
        this.updatedAt = updatedAt
    }
    static fromJson(json) {
        return new this({
            ...json,
            links: {
                show: new Link({ title: json.id, params: { id: json.id }, ...getRouteByName('astronauts-show') }),
                edit: new Link({ title: json.id, params: { id: json.id }, ...getRouteByName('astronauts-edit') }),
                delete: new Link({ title: json.id, params: { id: json.id }, ...getRouteByName('astronauts-delete') }),
            }
        })
    }
}
