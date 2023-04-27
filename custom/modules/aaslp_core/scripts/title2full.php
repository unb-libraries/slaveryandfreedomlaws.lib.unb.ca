<?php

/**
 * @file
 * Contains title2full.php.
 *
 * Copies title to full_title field when blank in aaslp.lib.unb.ca.
 */

use Drupal\node\Entity\Node;

refresh_nodes('legal_article');

/**
 * Loads and saves all nodes from a given bundle.
 *
 * @param string $bundle
 *   A string indicating the bundle to update.
 */
function refresh_nodes(string $bundle) {

  $nids = \Drupal::entityQuery('node')
    ->condition('type', $bundle)
    ->execute();

  $i = 0;

  if (!empty($nids)) {
    foreach ($nids as $nid) {
      $node = Node::load($nid);

      if ($node and empty($node->get('field_full_title')->getValue()[0]['value'])) {
        $title = $node->$title;
        echo "\n" . print_r($node->$title);
        $node->set('field_full_title', $title);
        $node->save();
        $full = $node->get('field_full_title')->getValue()[0]['value'];
        echo "[$i][+] [$full]->[Updated]\n";
        $i++;
      }
    }

    echo "\n$i records updated\n";
  }
}
