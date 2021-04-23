<?php

/**
 * @file
 * Contains gen_data.php.
 *
 * Generates test data for aaslp.lib.unb.ca.
 */

use Drupal\taxonomy\Entity\Term;
use Drupal\node\Entity\Node;

// Main.
for ($i = 1; $i <= 10; $i++) {
  echo rnd_nid('source') . "\n";
}

/**
 * Generates a numbered title.
 *
 * @param string $type
 *   Content type (bundle). Defaults to "Node".
 * @param int $number
 *   An identifying, non-zero, integer number. Defaults to NULL.
 * @param bool $test
 *   Prepend the word "Test"? Defaults to FALSE.
 */
function gen_title($type = 'Node', $number = NULL, $test = FALSE) {
  $str_test = $test ? 'Test ' : '';
  $str_number = !empty($number) ? ' ' . $number : '';
  return "$str_test$type$str_number";
}

/**
 * Generates lipsum content.
 *
 * @param int $paragraphs
 *   Number of paragraphs to generate. Defaults to 3.
 * @param string $length
 *   The pragraph length: short, medium (default), long, verylong.
 * @param bool $headers
 *   Add headers. Defaults to FALSE.
 * @param bool $plaintext
 *   Return plain text (no html). Defaults to TRUE.
 */
function gen_lipsum($paragraphs = 3, $length = 'medium', $headers = FALSE, $plaintext = FALSE) {
  $str_para = '/' . $paragraphs;
  $str_len = "/$length";
  $str_head = $headers ? '/headers' : '';
  $str_plain = $plaintext ? '/plaintext' : '';
  // Request lipsum by parameters using loripsum.net api.
  return file_get_contents("http://loripsum.net/api$str_para$str_len$str_head$str_plain");
}

/**
 * Returns a random taxonomy term id from the specified vocabulary.
 *
 * @param string $vid
 *   Vocabulary ID.
 */
function rnd_tid($vid) {
  $tids = !empty($vid) ? \Drupal::entityQuery('taxonomy_term')
    ->condition('vid', $vid)
    ->execute() : NULL;

  // Return random value from $tids.
  if (!empty($tids)) {
    return array_values($tids)[rand(0, (count($tids) - 1))];
  }
}

/**
 * Returns a random node id from the specified bundle (content type).
 *
 * @param string $bundle
 *   Bundle (content type) admin name.
 */
function rnd_nid($bundle) {
  $nids = !empty($bundle) ? \Drupal::entityQuery('node')
    ->condition('type', $bundle)
    ->execute() : NULL;

  // Return random value from $nids.
  if (!empty($nids)) {
    return array_values($nids)[rand(0, (count($nids) - 1))];
  }
}
