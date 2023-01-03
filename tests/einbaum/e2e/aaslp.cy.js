describe('Anglo-Atlantic Slave Law Project', () => {
  Cypress.Workflows.run('createEntity', {
    entityType: 'node',
    users: {
      authorized: [
        'aaslp_editor',
      ],
      unauthorized: [
        'user',
      ],
    },
    formUrl: '/node/add/legal_article',
    formData: {
      title: 'An Act for settling and regulating the Creation of Legal Articles',
    },
    successMessage: 'Legal Article An Act for settling and regulating the Creation of Legal Articles has been created.',
    successUrl: '/node/[0-9]+',
  })
})