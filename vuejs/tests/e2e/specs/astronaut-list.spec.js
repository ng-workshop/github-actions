describe('Load Astronaut list page', () => {
    it('Visits the Astronaut list page', () => {
        cy.server()
        cy.route('GET', 'http://symfony.workshop-ci.local/astronauts', 'fixture:astronauts.json')

        cy.visit('/astronauts/list')
        cy.get('#astronauts-list')
            .should('exist')
            .get('h2')
            .should('exist')
            .should('have.text', 'Astronaut list')

        cy.get('.button-astronaut-new')
            .should('exist')
            .should('have.text', 'Create')

        // cy.get('table')
        //     .should('exist')
        //     .get('thead')
        //     .should('exist')
        //     .get('th')
        //     .should('have.length', 8)
        //     .first()
        //     .get('div').should('have.text', 'Id')
        //     .next()
        //     .get('div').should('have.text', 'Avatar')
    })
})
