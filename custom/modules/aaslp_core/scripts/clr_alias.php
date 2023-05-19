<?php

/**
 * @file
 * Contains clr_alias.php.
 *
 * Clears all node alias for legal articles in slaveryandfreedomlaws.lib.unb.ca.
 */

$nids = \Drupal::entityQuery('node')
  ->condition('type', 'legal_article')
  ->execute();

$path_alias_manager = \Drupal::entityTypeManager()->getStorage('path_alias');

if (!empty($nids)) {
  foreach ($nids as $nid) {
    // Load all path alias for this node.
    $alias_objects = $path_alias_manager->loadByProperties([
      'path' => "/node/$nid",
    ]);

    foreach ($alias_objects as $alias_object) {
      $alias_object->delete();
      echo "[-] [node/{$nid}]->[Updated]\n";
    }
  }
}
