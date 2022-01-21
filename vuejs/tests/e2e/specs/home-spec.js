describe('Load Home page', () => {
  it('Visits the home page', () => {
    cy.visit('/')
    cy.get('.navbar-brand')
        .should('exist')
        .should('have.text', 'VueJS')

    cy.get('ul.navbar-nav')
        .should('exist')
        .get('li')
        .should('exist')
        .should('have.length', 2)
        .first()
        .should('exist')
        .should('have.text', ' Home ')
        .next()
        .should('exist')
        .should('have.text', ' Astronaut list ')

    cy.get('#home')
        .should('exist')
        .get('h2')
        .should('exist')
        .should('have.text', 'Home')

    cy.get('.show-pages')
        .should('exist')
        .get('p')
        .should('exist')
        .should('have.text', 'Pages:')

    cy.get('.page-list')
        .should('exist')
        .get('.page-item')
        .should('have.length', 2)
        .first()
        .should('exist')
        .should('have.text', 'Home')
        .next()
        .should('exist')
        .should('have.text', 'Astronaut list')
  })

  it('Navigate to Astronauts list page from Home by page-item element', () => {
    cy.server()
    cy.route('GET', 'http://symfony.workshop-ci.local/astronauts', 'fixture:astronauts.json')

    cy.visit('/')

    cy.get('.link-to-astronauts-list').click()

    cy.get('#astronauts-list')
        .should('exist')
        .get('h2')
        .should('exist')
        .should('have.text', 'Astronaut list')
  })
})
