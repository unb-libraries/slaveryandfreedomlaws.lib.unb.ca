<?php

/**
 * @file
 * Contains setup_terms.php.
 *
 * Sets/updates taxonomy term vocabularies for aaslp.lib.unb.ca.
 */

use Drupal\taxonomy\Entity\Term;

// Set-up locations.
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
    $found = \Drupal::entityQuery('taxonomy_term')
      ->condition('vid', $vid)
      ->condition('name', $term)
      ->execute();

    if (!$found) {
      $new_term = Term::create([
        'vid' => $vid,
        'name' => $term,
      ]);

      $new_term->set('parent', $parent_id);
      $new_term->save();

      echo "[+] [$term]->[$vid]\n";
      $new_terms[] = $new_term->id();
    }
    else {
      echo "[-] [$term] exists in [$vid]\n";
    }
  }

  return $new_terms;
}
