<?php

namespace Drupal\aaslp_core\Form;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Url;

/**
 * HomePageForm object. A form that can submit search for fulltext or metadata.
 */
class HomePageForm extends FormBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'aaslp_core_homepage';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Configure appropriate active tab/pane classes.
    $user_input = $form_state->getUserInput();
    $op = isset($user_input['op']) ? $user_input['op'] : NULL;
    $about_tab_class = " visible-xs";

    if ($op == 'Search FullText') {
      $title_tab_class = $title_pane_class = $about_pane_class = NULL;

      $fulltext_tab_class = " active";
      $fulltext_pane_class = "active in";
    }
    else {
      $fulltext_tab_class = $fulltext_pane_class = $about_pane_class = NULL;
      $title_tab_class = " active";
      $title_pane_class = "active in";
    }

    $form = [];
    $title_url = Url::fromUri("internal:/");
    $title_link_options = [
      'attributes' => [
        'id' => [
          'tab-title',
        ],
        'role' => [
          'tab',
        ],
        'data-toggle' => [
          'tab',
        ],
        'data-target' => [
          '#title',
        ],
        'aria-selected' => [
          'true',
        ],
        'tabindex' => [
          '0',
        ],
      ],
      'fragment' => 'title',
    ];
    $title_url->setOptions($title_link_options);

    $fulltext_url = Url::fromUri("internal:/");
    $fulltext_link_options = [
      'attributes' => [
        'id' => [
          'tab-fulltext',
        ],
        'role' => [
          'tab',
        ],
        'data-toggle' => [
          'tab',
        ],
        'data-target' => [
          '#fulltext',
        ],
        'aria-selected' => [
          'false',
        ],
      ],
      'fragment' => 'fulltext',
    ];
    $fulltext_url->setOptions($fulltext_link_options);

    $about_url = Url::fromUri("internal:/");
    $about_link_options = [
      'attributes' => [
        'id' => [
          'tab-about',
        ],
        'role' => [
          'tab',
        ],
        'data-toggle' => [
          'tab',
        ],
        'data-target' => [
          '#about',
        ],
        'aria-selected' => [
          'false',
        ],

      ],
      'fragment' => 'about',
    ];
    $about_url->setOptions($about_link_options);

    $blurb =
      "<p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
        veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
        commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
        velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
        occaecat cupidatat non proident, sunt in culpa qui officia deserunt
        mollit anim id est laborum.
      </p>";

    $form['blurb'] = [
      '#type' => 'markup',
      '#markup' => "<div class=\"hidden-xs message well\">" . $blurb . "</div>",
    ];

    $form['nav-tabs'] = [
      '#type' => 'html_tag',
      '#tag' => 'ul',
      '#attributes' => [
        'class' => [
          'nav',
          'nav-tabs',
        ],
        'role' => [
          'tablist',
        ],
      ],
    ];
    $form['nav-tabs']['title'] = [
      '#markup' => '<li class="tab' . $title_tab_class . '">' . Link::fromTextAndUrl($this->t('Title Search'), $title_url)
        ->toString() . '</li>',
    ];
    $form['nav-tabs']['fulltext'] = [
      '#markup' => '<li class="tab' . $fulltext_tab_class . '">' . Link::fromTextAndUrl($this->t('Fulltext Search'), $fulltext_url)
        ->toString() . '</li>',
    ];
    $form['nav-tabs']['about'] = [
      '#markup' => '<li class="tab' . $about_tab_class . '">' . Link::fromTextAndUrl($this->t('About'), $about_url)
        ->toString() . '</li>',
    ];

    $form['tab-content'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => [
          'tab-content',
          'search-form',
        ],
      ],
    ];
    $form['tab-content']['title'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => [
          'tab-pane',
          $title_pane_class,
        ],
        'id' => [
          'title',
        ],
        'aria-labelledby' => [
          'tab-title',
        ],
      ],
    ];
    $form['tab-content']['title']['input_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Search for Legal Article Titles'),
      '#description' => $this->t('Search by title, location, year, crime, punishment or combination, i.e. Jamaica 1800.'),
    ];

    $form['tab-content']['title']['submit_title'] = [
      '#type' => 'submit',
      '#value' => $this->t('Search/Browse Titles'),
      '#field_prefix' => '<span class="input-group-btn">',
    ];
    $form['tab-content']['fulltext'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => [
          'clearfix',
          'tab-pane',
          $fulltext_pane_class,
        ],
        'id' => [
          'fulltext',
        ],
        'aria-labelledby' => [
          'tab-fulltext',
        ],
      ],
    ];
    $form['tab-content']['fulltext']['wrapper'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => [
          'clearfix',
        ],
      ],
    ];
    $form['tab-content']['fulltext']['wrapper']['input_fulltext'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Search the fulltext of legal articles'),
      '#description' => $this->t('Search for keywords within the fulltext content of legal articles.'),
    ];
    $form['tab-content']['fulltext']['wrapper']['submit_fulltext'] = [
      '#type' => 'submit',
      '#value' => $this->t('Search FullText'),
      '#field_prefix' => '<span class="input-group-btn">',
      '#field_suffix' => '</span>',
      '#attributes' => [
        'class' => [
          'btn-danger',
        ],
      ],
    ];
    $form['tab-content']['fulltext']['notes'] = [
      '#type' => 'markup',
      '#markup' => '',
    ];

    $form['tab-content']['about'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => [
          'clearfix',
          'tab-pane',
          $about_pane_class,
        ],
        'id' => [
          'about',
        ],
        'aria-labelledby' => [
          'tab-about',
        ],
      ],
    ];
    $form['tab-content']['about']['wrapper'] = [
      '#type' => 'container',
    ];
    $form['tab-content']['about']['wrapper']['blurb'] = [
      '#type' => 'markup',
      '#markup' => $blurb,
    ];

    $form['#cache'] = [
      'keys' => ['aaslp_frontpage'],
      'contexts' => ['url'],
      'max-age' => Cache::PERMANENT,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    /* Enforce fulltext search term */
    $value = (string) $values['input_fulltext'];
    $op = (string) $form_state->getValue('op');

    if ($op === 'Search FullText' && empty($value)) {
      $form_state->setErrorByName('input_fulltext', $this->t('Please provide a fulltext search term'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $op = (string) $form_state->getValue('op');

    $input_fulltext = (string) $values['input_fulltext'];
    $input_title = (string) $values['input_title'];

    if ($op === 'Search FullText') {
      $query = $this->getQueryFromValue($input_fulltext);
      $form_state->setRedirectUrl(
        Url::fromUri("internal:/search?search_api_fulltext=$query")
      );
    }
    elseif ($op === 'Search/Browse Titles') {
      $query = $this->getQueryFromValue($input_title);
      $form_state->setRedirectUrl(
        Url::fromUri("internal:/search?search_api_fulltext=$query")
      );
    }

  }

  /**
   * Get the query from a form state value.
   *
   * @param object $value
   *   The form state value.
   *
   * @return string
   *   The string value of the form state value.
   */
  private function getQueryFromValue($value) {
    return (string) $value;
  }

}
