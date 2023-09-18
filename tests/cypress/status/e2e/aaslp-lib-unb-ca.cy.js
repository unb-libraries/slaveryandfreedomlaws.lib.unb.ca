const host = 'https://slaveryandfreedomlaws.lib.unb.ca'
describe('Laws of Enslavement and Freedom', {baseUrl: host, groups: ['sites']}, () => {
  context('Front page', {baseUrl: host}, () => {
    beforeEach(() => {
      cy.visit('/')
      cy.title()
        .should('contain', 'Laws of Enslavement and Freedom')
    })

    specify('Submitting "Title Search" query should lead to "laws" page', () => {
      cy.get('form#aaslp-core-homepage')
        .submit()
      cy.url()
        .should('match', /\/laws/)
      cy.get('h1')
        .should('contain', 'Title Search')
    })
  })

})
