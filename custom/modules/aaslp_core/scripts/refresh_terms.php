<?php

/**
 * @file
 * Contains refresh_terms.php.
 *
 * Clears node bundles for aaslp.lib.unb.ca.
 */

use Drupal\taxonomy\Entity\Term;

refresh_terms('locations');

/**
 * Loads and saves all terms from a given vocabulary.
 *
 * @param string $vocabulary
 *   A string indicating the vocabulary to update.
 */
function refresh_terms(string $vocabulary) {

  $tids = \Drupal::entityQuery('taxonomy_term')
    ->condition('vid', $vocabulary)
    ->execute();

  if (!empty($tids)) {
    foreach ($tids as $tid) {
      $term = Term::load($tid);

      if ($term) {
        $name = $term->getName();
        $term->save();
        echo "[-] [$name]->[Updated]\n";
      }
    }
  }
}
