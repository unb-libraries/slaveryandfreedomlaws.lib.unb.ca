# Project Documentation: slaveryandfreedomlaws.lib.unb.ca

## Local Development Procedures
A simple ```dockworker start-over``` is enough to spin up a local development instance.

Some quick notes:
* The project shorthand slug (e.g. for JIRA) is FREEDOM.
* The configured theme is ```aaslp_lib_unb_ca```, and all changes should be made to it. Its location in the repository is ```/themes/custom```.
* The theme ```aaslp_lib_unb_ca``` inherits from ```bootstrap4```.
* There is also a minor-customization admin theme named ```aaslp_admin_theme```.
* The teme ```aaslp_admin_theme``` inherits from ```seven```.  
* Once deployed locally, any changes to the _themes_ or _assets_ can then be updated with the usual: ```dockworker theme:build-all```

## Data Overview
FREEDOM uses Drupal content structures exclusively. No custom entities are defined. Other content structures include:
* Legal Article	— This is the main data structure for FREEDOM. Each record represents and documents a legal article, including location, date, full written text, etc. 

## Module Overview
* context_branding: Offers a custom branding block which renders the site title as a no-link H1 header on homepage only.
