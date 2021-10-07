<?php

namespace Drupal\context_branding\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Path\PathMatcher;
use Drupal\Core\Site\Settings;

/**
 * Provides a custom block for site branding (non-homepage version).
 *
 * @Block(
 *   id = "context_branding_block",
 *   admin_label = @Translation("Contextual Branding"),
 *   category = @Translation("Misc"),
 * )
 */
class ContextBrandingBlock extends BlockBase {
  /**
   * For path matcher dependency injection.
   *
   * @var Drupal\Core\Path\PathMatcher
   */
  protected $pathMatcher;

  /**
   * For site settings dependency injection.
   *
   * @var Drupal\Core\Site\Settings
   */
  protected $siteSettings;

  /**
   * Constructs a new ContextBrandingBlock object.
   *
   * @param Drupal\Core\Path\PathMatcher $pathMatcher
   *   The path matcher object.
   * @param Drupal\Core\Site\Settings $siteSettings
   *   The site settings object.
   */
/*
  public function __construct($pathMatcher, $siteSettings) {
    $this->pathMatcher = $pathMatcher;
    $this->siteSettings = $siteSettings;
  }
*/
  /**
   * {@inheritdoc}
   */
  public function build() {
    $is_front = \Drupal::service('path.matcher')->isFrontPage();
    $site_config = \Drupal::config('system.site');
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
