<?php

/**
 * @file
 * Contains clr_nodes.php.
 *
 * Clears node bundles for aaslp.lib.unb.ca.
 */

use Drupal\node\Entity\Node;

clr_nodes('source');
clr_nodes('legal_article');

/**
 * Clear all nodes from a given bundle.
 *
 * @param string $bundle
 *   A string indicating the bundle to update.
 */
function clr_nodes(string $bundle) {

  $nids = \Drupal::entityQuery('node')
    ->condition('type', $bundle)
    ->accessCheck(TRUE)
    ->accesscheck(false)->execute();

  if (!empty($nids)) {
    foreach ($nids as $nid) {
      $node = Node::load($nid);

      if ($node) {
        $title = $node->getTitle();
        $node->delete();
        echo "[-] [$title]->[DELETED]\n";
      }
    }
  }
}
