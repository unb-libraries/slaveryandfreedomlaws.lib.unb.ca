<?php

/**
 * @file
 * Contains refresh_nodes.php.
 *
 * Clears node bundles for aaslp.lib.unb.ca.
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
    ->accesscheck(false)->execute();

  if (!empty($nids)) {
    foreach ($nids as $nid) {
      $node = Node::load($nid);

      if ($node) {
        $title = $node->getTitle();
        $node->save();
        echo "[-] [$title]->[Updated]\n";
      }
    }
  }
}
