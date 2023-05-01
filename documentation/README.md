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
* Legal Article	(node) — This is the main data structure for FREEDOM. Each record represents and documents a legal article, including location, date, full written text, etc.
* Source (node) — This structure is used to identify and reference legal article sources.
* Saved Coordinates (node) — This is an auxiliary data structure for storing named sets of geographic coordinates (for law location map display).
* Law Tags (taxonomy) — Controlled vocabulary to manage reference tags assigned to legal articles.
* Locations (taxonomy) — Controlled vocabulary to manage named law article locations. 

## Module Overview
* aaslp_admin: Encompasses all customization pertaining to administrative site tasks.
* aaslp_search: Provides extended search functionality (indexing, facets, etc).
* aaslp_core: Core custom functionality module. Encompasses all custom functionality not directly releated to specific data structure CRUD.
* legal_article: Encompasses all custom functionality related to the legal_article data structure.
* unb_lib_ck_annotator: Provides a custom annotation plugin for CKEditor.   
* context_branding: Offers a custom branding block which renders the site title as a no-link H1 header on homepage only.
