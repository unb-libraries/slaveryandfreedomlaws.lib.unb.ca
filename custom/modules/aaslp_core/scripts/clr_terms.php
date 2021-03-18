<?php

/**
 * @file
 * Contains clr_terms.php.
 *
 * Clears taxonomy term vocabularies for aaslp.lib.unb.ca.
 */

use Drupal\taxonomy\Entity\Term;

clr_terms('locations');
clr_terms('categories');
clr_terms('crimes');
clr_terms('punishments');

/**
 * Clear all terms from a given vocabulary.
 *
 * @param string $vid
 *   A string indicating the id of the vocabulary to update.
 */
function clr_terms(string $vid) {

  $tids = \Drupal::entityQuery('taxonomy_term')
    ->condition('vid', $vid)
    ->execute();

  if (!empty($tids)) {
    foreach ($tids as $tid) {
      $term = Term::load($tid);

      if ($term) {
        $tname = $term->getName();
        $term->delete();
        echo "[-] [$tname]->[DELETED]\n";
      }
    }
  }
}
