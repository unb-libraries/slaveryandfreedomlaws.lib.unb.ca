const { defineConfig } = require('@unb-libraries/einbaum')

module.exports = defineConfig({
  baseUrl: 'http://local-aaslp.lib.unb.ca:3111',
  plugins: {
    "@unb-libraries/cypress-drupal": {},
  },
})
