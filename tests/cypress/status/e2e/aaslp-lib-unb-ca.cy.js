const host = 'https://slaveryandfreedomlaws.lib.unb.ca'
describe('Laws of Enslavement and Freedom', {baseUrl: host, groups: ['sites']}, () => {
  context('Front page', {baseUrl: host}, () => {
    beforeEach(() => {
      cy.visit('/')
      cy.title()
        .should('contain', 'The Anglo-Atlantic Slave Law Project')
    })

    specify('Submitting "Title Search" query should lead to "laws" page', () => {
      cy.get('form#aaslp-core-homepage')
        .submit()
      cy.url()
        .should('match', /\/laws/)
      cy.get('h1')
        .should('contain', 'Title Search')
    })

    specify('Navigation menu should contain "Timeline" link', () => {
      cy.get('nav[role="navigation"] a')
        .contains('Timeline')
        .its('0.href')
        .should('match', /\/timeline/)
    })
  })

})
