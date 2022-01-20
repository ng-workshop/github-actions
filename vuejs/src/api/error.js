export default class extends Error {
    constructor(response) {
        super();

        this.data = response.data
        this.statusCode = response.statusCode
        this.statusMessage = response.statusText
        this.request = response.request || {}
        this.headers = response.headers || {}
        this.config = response.config || {}
    }
}
