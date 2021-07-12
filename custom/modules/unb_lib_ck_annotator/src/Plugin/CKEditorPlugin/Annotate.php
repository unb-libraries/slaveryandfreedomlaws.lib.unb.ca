<?php

namespace Drupal\unb_lib_ck_annotator\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginBase;
use Drupal\ckeditor\CKEditorPluginCssInterface;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "Annotator" CKEditor plugin. Inserts annotations.
 *
 * @CKEditorPlugin(
 *   id = "annotate",
 *   label = @Translation("CKEditor Annotator"),
 *   module = "unb_lib_ck_annotator"
 * )
 */
class Annotate extends CKEditorPluginBase implements CKEditorPluginCssInterface {

  /**
   * {@inheritdoc}
   */
  public function getDependencies(Editor $editor) {
    return [];
  }

  /**
   * Implements \Drupal\ckeditor\Plugin\CKEditorPluginInterface::isInternal().
   */
  public function isInternal() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function getFile() {
    return drupal_get_path('module', 'unb_lib_ck_annotator') . '/js/plugins/annotate/plugin.js';
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    return [
      'annotate' => [
        'label' => t('Insert annotation'),
        'image' => drupal_get_path('module', 'unb_lib_ck_annotator') .
        '/js/plugins/annotate/icons/annotate.png',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getConfig(Editor $editor) {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getCssFiles(Editor $editor) {
    return [];
  }

}
