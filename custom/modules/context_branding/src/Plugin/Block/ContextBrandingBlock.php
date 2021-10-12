<?php

namespace Drupal\context_branding\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a custom block for site branding (non-homepage version).
 *
 * @Block(
 *   id = "context_branding_block",
 *   admin_label = @Translation("Contextual Branding"),
 *   category = @Translation("Misc"),
 * )
 */
class ContextBrandingBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * For services dependency injection.
   *
   * @var ContainerInterface $service
   */
  protected $service;

  /**
   * Class constructor.
   *
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $service_container
   */
  public function __construct(array $configuration, $plugin_id,
  $plugin_definition, ContainerInterface $service_container) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->service = $service_container;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $service_container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('service_container')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $is_front = $this->service->get('path.matcher')->isFrontPage();
    $site_config = $this->service->get('config.factory')->get('system.site');
    $site_name = $site_config->get('name');
    $site_slogan = $site_config->get('slogan');

    if ($is_front) {
      $site_title = "
        <h1 class='site-title'>
          $site_name
        </h1>
      ";
    }
    else {
      $site_title = "
        <a href='/' title='Home' rel='home' class='site-title'>
          $site_name
        </a>
      ";
    }

    $markup = "
      <div class='contextual-region block block-system block-system-branding-block'>
        <div class='navbar-brand d-flex align-items-center'>
          <div>
            $site_title
            <div class='site-slogan'>
              $site_slogan
            </div>
          </div>
        </div>
      </div>
    ";

    return [
      '#markup' => $this->t($markup),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

}
