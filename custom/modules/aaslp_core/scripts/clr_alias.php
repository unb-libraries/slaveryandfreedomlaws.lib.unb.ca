<?php

/**
 * @file
 * Contains clr_alias.php.
 *
 * Clears node alias for slaveryandfreedomlaws.lib.unb.ca.
 */

$path_alias_manager = \Drupal::entityTypeManager()->getStorage('path_alias');

// Load all path alias for this node for es language.
$alias_objects = $path_alias_manager->loadByProperties([
  'path'     => '/node/' . $nid,
  'langcode' => 'en',
]);

foreach ($alias_objects as $alias_object) {
  $alias_object->delete();
}
