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
// Generate test sources.
for ($i = 1; $i <= 2; $i++) {
  gen_source($i);
}

// Generate test articles.
for ($i = 1; $i <= 50; $i++) {
  gen_article($i, 5);
}

/**
 * Generates a numbered Legal Article node.
 *
 * @param int $number
 *   An identifying, non-zero, integer number. Defaults to NULL.
 * @param int $multimax
 *   Maximum number of entries for multi-value fields. Defaults to 1.
 */
function gen_article($number = NULL, $multimax = 1) {
  // Create article body.
  $full_text = gen_lipsum(4, 'medium', TRUE, FALSE);
  // Create node.
  $article = Node::create(['type' => 'legal_article']);
  // Populate fields.
  $article->field_source->target_id = rnd_nid('source');
  $title = gen_title('Legal Article', $number, TRUE);
  $article->title = $title;
  $article->field_full_title = gen_title('Full Title', $number, TRUE);
  $article->field_citation = gen_title('Citation', $number, TRUE);
  $article->field_date = gen_date("1500-01-01", "1900-01-01");
  $article->field_location->target_id = rnd_tid('locations');
  // Crimes.
  $items = rand(1, $multimax);

  for ($i = 1; $i <= $items; $i++) {
    $article->field_crimes[] = rnd_tid('crimes');
  }
  // Punishments.
  $items = rand(1, $multimax);

  for ($i = 1; $i <= $items; $i++) {
    $article->field_punishments[] = rnd_tid('punishments');
  }

  $article->field_category = rnd_tid('law_categories');

  $article->body->value = $full_text;
  $article->body->format = 'unb_libraries';
  // Transcription annotations.
  $words = rnd_words(strip_tags($full_text), rand(1, $multimax));

  foreach ($words as $word) {
    // Description.
    $desc = gen_lipsum(1, 'small', FALSE, TRUE);
    // Create and save annotation term.
    $anno = Term::create([
      'name' => $word,
      'description' => $desc,
      'vid' => 'annotations',
    ]);

    $anno->save();
    $tid = $anno->id();

    // Add ID to multi field.
    $article->field_annotations[] = [
      'target_id' => $tid,
      'target_revision_id' => (string) ($tid + 1),
    ];
  }
  // Editorial annotations.
  $words = rnd_words(strip_tags($full_text), rand(1, $multimax));

  foreach ($words as $word) {
    // Description.
    $desc = gen_lipsum(1, 'small', FALSE, TRUE);
    // Create and save annotation term.
    $anno = Term::create([
      'name' => $word,
      'description' => $desc,
      'vid' => 'annotations',
    ]);

    $anno->save();
    $tid = $anno->id();

    // Add ID to multi field.
    $article->field_editorial_annotations[] = [
      'target_id' => $tid,
      'target_revision_id' => (string) ($tid + 1),
    ];
  }

  $article->field_notes->value = gen_lipsum(1, 'medium', FALSE, TRUE);

  $article->save();
  $aid = $article->id();
  echo "Generated Legal Article: $title ($aid)\n";

}

/**
 * Generates a numbered Source node.
 *
 * @param int $number
 *   An identifying, non-zero, integer number. Defaults to NULL.
 */
function gen_source($number = NULL) {
  $source = Node::create(['type' => 'source']);
  $title = gen_title('Source', $number, TRUE);
  $source->title = $title;
  $source->body->value = gen_lipsum(1, 'medium', FALSE, TRUE);
  $source->body->format = 'unb_libraries';
  $source->save();
  $sid = $source->id();
  echo "Generated Source: $title ($sid)\n";
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
  return file_get_contents("https://loripsum.net/api$str_para$str_len$str_head$str_plain");
}

/**
 * Generates a random date.
 *
 * @param string $from
 *   The minimum date value.
 * @param string $to
 *   The maximum date value.
 */
function gen_date($from = "1001-01-01", $to = "2100-01-01") {
  $t_from = strtotime($from);
  $t_to = strtotime($to);
  return date("Y-m-d", rand($t_from, $t_to));
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

/**
 * Returns a an array with random words from the provided text.
 *
 * @param string $text
 *   The text to retrieve words from.
 * @param int $amount
 *   The amount of words to return. Defaults to 1.
 */
function rnd_words($text, $amount = 1) {
  $source = !empty($text) ? explode(' ', $text) : NULL;

  if ($source) {
    $words = [];

    for ($i = 0; $i < $amount; $i++) {
      $word = $source[rand(0, (count($source) - 1))];
      $word = preg_replace('/[^a-z]+/i', '', $word);
      $words[] = $word;
    }

    return $words;
  }
  else {
    return FALSE;
  }
}
