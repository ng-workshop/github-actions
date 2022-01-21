describe('Test navigation with navbar', () => {
    it('Navigate to Astronauts list page from Home by nav', () => {
        cy.server()
        cy.route('GET', 'http://symfony.workshop-ci.local/astronauts', 'fixture:astronauts.json')

        cy.visit('/')

        cy.get('.nav-link-home > a')
            .should('have.class', 'router-link-exact-active')
        cy.get('.nav-link-astronauts-list > a')
            .should('not.have.class', 'router-link-exact-active')

        cy.get('.nav-link-astronauts-list > a').click()

        cy.get('.nav-link-home > a')
            .should('not.have.class', 'router-link-exact-active')
        cy.get('.nav-link-astronauts-list > a')
            .should('have.class', 'router-link-exact-active')

        cy.get('#astronauts-list')
            .should('exist')
            .get('h2')
            .should('exist')
            .should('have.text', 'Astronaut list')
    })

    it('Navigate to Home page from astronauts list', () => {
        cy.server()
        cy.route('GET', 'http://symfony.workshop-ci.local/astronauts', 'fixture:astronauts.json')

        cy.visit('/astronauts/list')

        cy.get('.nav-link-home > a')
            .should('not.have.class', 'router-link-exact-active')
        cy.get('.nav-link-astronauts-list > a')
            .should('have.class', 'router-link-exact-active')

        cy.get('.nav-link-home > a').click()

        cy.get('.nav-link-home > a')
            .should('have.class', 'router-link-exact-active')
        cy.get('.nav-link-astronauts-list > a')
            .should('not.have.class', 'router-link-exact-active')

        cy.get('#home')
            .should('exist')
            .get('h2')
            .should('exist')
            .should('have.text', 'Home')
    })
})
