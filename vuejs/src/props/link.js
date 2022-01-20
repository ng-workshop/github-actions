export default class {
    constructor({ title, name, params = {}, query = {}, meta ={} }) {
        this.title = title
        this.name = name
        this.params = params
        this.query = query
        this.meta = meta
        this.to = { name, params, query, meta }
    }
    static fromRoute(route) {
        return new this({ title: route.meta.title, ...route})
    }
}
