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
  'Caribbean',
  'Greater Atlantic World',
  'North America',
];

// Caribbean.
// Create parent.
/* $parent = add_terms('locations', [$parent_locs[0]])[0]; */
// Create children.
$children = [
  'Anguilla',
  'Antigua',
  'Bahamas',
  'Barbados',
  'Berbice',
  'Bermuda',
  'British Honduras (Belize)',
  'Demerara',
  'Dominica',
  'Grenada',
  'Jamaica',
  'Leeward Islands',
  'Montserrat',
  'Nevis',
  'St. Christopher',
  'St. Lucia',
  'St. Vincent',
  'Tobago',
  'Trinidad',
];

/* add_terms('locations', $children, $parent); */

// Greater Atlantic World.
// Create parent.
/* $parent = add_terms('locations', [$parent_locs[2]])[0]; */
// Create children.
$children = [
  'Cape of Good Hope',
  'Mauritius',
];

/* add_terms('locations', $children, $parent); */

// North America.
// Create parent.
/* $parent = add_terms('locations', [$parent_locs[1]])[0]; */
// Create children.
$children = [
  'Connecticut',
  'Delaware',
  'Georgia',
  'New Hampshire',
  'New Jersey',
  'New York',
  'North Carolina',
  'Maryland',
  'Massachusetts',
  'Pennsylvania',
  'Prince Edward Island',
  'Rhode Island',
  'South Carolina',
  'Virginia',
];

/* add_terms('locations', $children, $parent); */

// Set up tags.
$tags = [
  'Abolition',
  'Absenteeism',
  'Advertisements',
  'Age of Enslaved People',
  'Aged/Elderly Bondspeople',
  'Armed conflict',
  'Arson',
  'Baptism',
  'Branding',
  'Buying and selling goods',
  'Cage',
  'Capital Offense',
  'Childbirth',
  'Children, Enslaved',
  'Clandestine meetings',
  'Corporeal punishment',
  'Curfew',
  'Dismemberment/Loss of Limb',
  'Drivers',
  'Education',
  'Felony',
  'Foreigners',
  'Free People of Colour',
  'Haitian Revolution',
  'Harming or threatening whites',
  'Health of Enslaved People',
  'Holidays',
  'Hospital',
  'Indigenous',
  'Intoxication',
  'Jewish People',
  'Jail/confinement',
  'Jury',
  'Killing of an Enslaved Person',
  'Livestock',
  'Manumission',
  'Marriage',
  'Maroons',
  'Murder',
  'Mutilation',
  'Nose Slit',
  'Obeah',
  'Owning property',
  'Perjury',
  'Poison',
  'Poverty',
  'Pregnant Bondswomen',
  'Pro-natal policy',
  'Provision Grounds',
  'Provost Marshall',
  'Punishment, shackles/iron',
  'Quakers',
  'Real Estate',
  'Rebellion/Conspiracy',
  'Religion',
  'Reward',
  'Running away',
  'Selling/Trading with Enslaved',
  'Sickness',
  'Slave Trade',
  'Take Up/Custody of Enslaved',
  'Taxes and Duties',
  'Testimony of free people of colour',
  'Testimony of enslaved people',
  'Tickets',
  'Transportation',
  'Theft',
  'Weapons',
  'Without benefit of clergy',
  'Whipping',
  'White Servants',
  'Workhouse',
];

add_terms('law_tags', $tags);

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
