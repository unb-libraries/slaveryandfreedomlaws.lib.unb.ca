describe('Anglo-Atlantic Slave Law Project', () => {
  context('Front page', () => {
    it('should contain a title', () => {
      cy.visit('/')
      cy.title()
        .should('not.contain', 'The Anglo-Atlantic Slave Law Project')
    })
  })

})
