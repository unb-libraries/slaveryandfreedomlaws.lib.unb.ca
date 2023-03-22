<?php

namespace Drupal\aaslp_core\Controller;

use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * HomePageTitleController object. Controls homepage route.
 */
class HomePageTitleController {

  use StringTranslationTrait;

  /**
   * Get the title of the homepage.
   *
   * @return string
   *   The title of the homepage.
   */
  public function getTitle() {
    return $this->t('Laws of Enslavement and Freedom in the Anglo-Atlantic World');
  }

}
