<?php

namespace Drupal\unb_lib_ck_annotator\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginBase;
use Drupal\ckeditor\CKEditorPluginCssInterface;
use Drupal\editor\Entity\Editor;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactory;

/**
 * Defines the "Annotator" CKEditor plugin. Inserts annotations.
 *
 * @CKEditorPlugin(
 *   id = "annotate",
 *   label = @Translation("CKEditor Annotator"),
 *   module = "unb_lib_ck_annotator"
 * )
 */
class Annotate extends CKEditorPluginBase implements CKEditorPluginCssInterface, ContainerFactoryPluginInterface {

  /**
   * For service dependency injection.
   *
   * @var Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;

  /**
   * Class constructor.
   *
   * @param array $configuration
   *   The block configuration.
   * @param string $plugin_id
   *   The plugin identifier.
   * @param mixed $plugin_definition
   *   The plugin definition.
   * @param Drupal\Core\Config\ConfigFactory $config_factory
   *   For using services via dependency injection.
   */
  public function __construct(array $configuration,
  $plugin_id,
  $plugin_definition,
  ConfigFactory $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
  }

  /**
   * Object create method.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Container interface.
   * @param array $configuration
   *   The block configuration.
   * @param string $plugin_id
   *   The plugin identifier.
   * @param mixed $plugin_definition
   *   The plugin definition.
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory')
    );
  }

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
        'label' => $this->t('Insert annotation'),
        'image' => drupal_get_path('module', 'unb_lib_ck_annotator') .
        '/js/plugins/annotate/icons/annotate.png',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getConfig(Editor $editor) {
    // Get immutable Config (Read Only).
    $groups =
      $this->configFactory->get('unb_lib_ck_annotator.settings')->get('groups');
    // Prepare additional configuration for plugin.
    $config['groups'] = [
      'numbered' => [
        'enabled' => $groups['numbered']['enabled'],
        'label' => $groups['numbered']['label'],
      ],
      'lowercase' => [
        'enabled' => $groups['lowercase']['enabled'],
        'label' => $groups['lowercase']['label'],
      ],
      'uppercase' => [
        'enabled' => $groups['uppercase']['enabled'],
        'label' => $groups['uppercase']['label'],
      ],
    ];

    return $config;
  }

  /**
   * {@inheritdoc}
   */
  public function getCssFiles(Editor $editor) {
    return [];
  }

}
