<?php

/**
 * @file
 * Contains setup_terms.php.
 *
 * Sets/updates taxonomy term vocabularies for aaslp.lib.unb.ca.
 */

use Drupal\taxonomy\Entity\Term;

// Set up locations.
// Parent locations.
$parent_locs = [
  'Caribbean, Mid-Atlantic, South America',
  'Jamaica and its dependencies',
  'Leeward Islands',
  'Middle Colonies (1706-1783)',
  'New England Colonies (1706-1783)',
  'Pre-confederation Canada',
  'Windward Islands',
  'Other',
];

// Caribbean.
// Create parent.
$parent = add_terms('locations', [$parent_locs[0]])[0];
// Create children.
$children = [
  'Bahamas',
  'Berbice',
  'Bermuda',
  'Cape of Good Hope',
  'Demerara',
  'Dominica',
  'Honduras/Belize',
  'Jamaica',
  'Mauritius',
  'St. Lucia',
  'St. Vincent and the Grenadines',
  'Tobago',
  'Trinidad',
];

add_terms('locations', $children, $parent);

// Jamaica.
// Create parent.
$parent = add_terms('locations', [$parent_locs[1]])[0];
// Create children.
$children = [
  'Bay Islands',
  'Belize (British Honduras)',
  'Cayman Islands',
  'Jamaica',
  'Mosquito Coast',
];

add_terms('locations', $children, $parent);

// Leeward.
// Create parent.
$parent = add_terms('locations', [$parent_locs[2]])[0];
// Create children.
$children = [
  'Anguilla',
  'Antigua',
  'Barbuda',
  'British Virgin Islands',
  'Montserrat',
  'Nevis',
  'St. Christopher',
];

add_terms('locations', $children, $parent);

// Middle Colonies.
// Create parent.
$parent = add_terms('locations', [$parent_locs[3]])[0];
// Create children.
$children = [
  'Delaware',
  'New York',
  'New Jersey',
  'Pennsylvania',
];

add_terms('locations', $children, $parent);

// New England Colonies.
// Create parent.
$parent = add_terms('locations', [$parent_locs[4]])[0];
// Create children.
$children = [
  'Connecticut',
  'Massachusetts',
  'New Hampshire',
  'Rhode Island & Providence',
];

add_terms('locations', $children, $parent);

// Pre-confederation Canada.
// Create parent.
$parent = add_terms('locations', [$parent_locs[5]])[0];
// Create children.
$children = [
  'British Arctic Territories',
  'Island of St. John',
  'Newfoundland',
  'North-Western Territory',
  'Nova Scotia',
  'Quebec',
  'Rupert’s Land',
];

add_terms('locations', $children, $parent);

// Windward Islands.
// Create parent.
$parent = add_terms('locations', [$parent_locs[6]])[0];
// Create children.
$children = [
  'Barbados',
  'Dominica (detached from Grenada in 1770)',
  'Grenada',
  'St. Vincent',
  'Tobago (detached from Grenada in 1768)',
];

add_terms('locations', $children, $parent);

// Other.
// Create parent.
$parent = add_terms('locations', [$parent_locs[7]])[0];
// Create children.
$children = [
  'East and West Florida (Spain 1783-1823, U.S. after 1823)',
  'Georgia',
  'Indian Reserve (U.S. after 1783)',
  'Quebec southwest of the Great Lakes (U.S. after 1783)',
  'Maryland',
  'North Carolina',
  'South Carolina',
  'Virginia',
];

add_terms('locations', $children, $parent);

// Set up categories.
$categories = [
  'Ameliorative',
  'Consolidated',
  'Manumission',
  'Punitive Laws',
  'Hiring',
  'Property in Persons',
  'Protective Law',
  'Registry of Enslaved People',
  'Reward',
  'Slave Trade',
];

add_terms('law_categories', $categories);

// Set up crimes.
$crimes = [
  'Arson',
  'Gathering in groups',
  'Hiding a runaway',
  'Rape',
  'Running away',
  'Theft',
  'Use of instruments/weapons',
  'Violence against any white person',
];

add_terms('crimes', $crimes);

// Set up punishments.
$punishments = [
  'Whip/flog',
  'Branding',
  'Transportation',
  'Stocks',
  'Pillory',
  'Workhouse',
  'Dismemberment',
  'Slitting of nose',
  'Slitting of ears',
  'However he/she shall think fit to inflict',
  'Death',
  'Castration',
];

add_terms('punishments', $punishments);

/**
 * Add multiple terms to a given vocabulary.
 *
 * @param string $vid
 *   A string indicating the id of the vocabulary to update.
 * @param array $terms
 *   An array containing the names of the terms to add.
 * @param int $parent_id
 *   The ID of the parent term, if any.
 */
function add_terms(string $vid, array $terms, int $parent_id = NULL) {

  foreach ($terms as $term) {
    $new_term = Term::create([
      'vid' => $vid,
      'name' => $term,
    ]);

    $new_term->set('parent', $parent_id);
    $new_term->save();

    echo "[+] [$term]->[$vid]\n";
    $new_terms[] = $new_term->id();
  }

  return $new_terms;
}
