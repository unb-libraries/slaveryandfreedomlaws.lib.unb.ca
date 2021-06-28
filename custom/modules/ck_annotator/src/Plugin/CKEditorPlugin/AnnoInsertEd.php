<?php

namespace Drupal\ck_annotator\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginBase;
use Drupal\ckeditor\CKEditorPluginCssInterface;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "Annotator (editorial)" CKEditor plugin. Inserts annotations.
 *
 * @CKEditorPlugin(
 *   id = "anno_insert_ed",
 *   label = @Translation("CKEditor Annotator (editorial)"),
 *   module = "ck_annotator"
 * )
 */
class AnnoInsertEd extends CKEditorPluginBase implements CKEditorPluginCssInterface {

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
    return drupal_get_path('module', 'ck_annotator') . '/js/plugins/ck_annotate_ed/anno_ed_plugin.js';
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    return [
      'anno_insert_ed' => [
        'label' => t('Insert editorial annotation'),
        'image' => drupal_get_path('module', 'ck_annotator') .
        '/js/plugins/ck_annotate_ed/icons/anno_insert_ed.png',
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
