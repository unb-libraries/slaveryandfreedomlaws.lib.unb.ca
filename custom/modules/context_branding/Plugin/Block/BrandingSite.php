<?php

namespace Drupal\context_branding\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom block for site branding (non-homepage version).
 *
 * @Block(
 *   id = "branding_site",
 *   admin_label = @Translation("Contextual Branding (except home)"),
 *   category = @Translation("Misc"),
 * )
 */
class BrandingSite extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $site_title ='Site Title';
    $site_slogan ='Site Slogan';

    $markup = "
      <div id='' class='contextual-region block block-system block-system-branding-block'>
        <div class='navbar-brand d-flex align-items-center'>
          <div>
            <a href='/' title='Home' rel='home' class='site-title'>
              $site_title
            </a>
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

}
