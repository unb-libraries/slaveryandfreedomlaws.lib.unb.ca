<?php

/**
 * @file
 * Contains clr_sys_schema.php.
 *
 * Clears system.schema entries for aaslp.lib.unb.ca.
 */

clr_sys_schema('sources');
clr_sys_schema('devel');

/**
 * Clear all system.schema entries matching name.
 *
 * @param string $name
 *   A string indicating the entry name.
 */
function clr_sys_schema(string $name) {
  \Drupal::service('database')->delete('key_value')->condition('name', $name)->accesscheck(false)->execute();
}
