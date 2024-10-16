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
    $op = $user_input['op'] ?? NULL;

    if ($op == 'Search FullText') {
      $title_tab_class = $title_pane_class = NULL;

      $fulltext_tab_class = " active";
      $fulltext_pane_class = "active in";
    }
    else {
      $fulltext_tab_class = $fulltext_pane_class = NULL;
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
        'data-bs-toggle' => [
          'tab',
        ],
        'data-bs-target' => [
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
        'data-bs-toggle' => [
          'tab',
        ],
        'data-bs-target' => [
          '#fulltext',
        ],
        'aria-selected' => [
          'false',
        ],
      ],
      'fragment' => 'fulltext',
    ];
    $fulltext_url->setOptions($fulltext_link_options);

    $blurb =
      "<p>The Laws of Enslavement and Freedom in the Anglo-Atlantic World is an 
      ongoing project that seeks to provide digital access to the laws governing 
      slavery and freedom in the Anglo-Atlantic World, from the founding laws 
      of the seventeenth century to the laws that governed emancipation in the 
      nineteenth century. <a href='/about'>
      About the project ></a></p>"
    ;

    $form['blurb'] = [
      '#type' => 'markup',
      '#markup' => "<div id='site-blurb'>$blurb</div>",
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
      '#markup' => '<li class="tab' . $title_tab_class . '">' . Link::fromTextAndUrl($this->t('TITLE SEARCH'), $title_url)
        ->toString() . '</li>',
    ];
    $form['nav-tabs']['fulltext'] = [
      '#markup' => '<li class="tab' . $fulltext_tab_class . '">' . Link::fromTextAndUrl($this->t('FULLTEXT SEARCH'), $fulltext_url)
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
      '#title' => $this->t('Search legal article titles'),
      '#description' => $this->t('Search by title, location, year, tags, abstract, or combination, i.e. Jamaica 1744. <a href="/tags">View all tags.</a>'),
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
    ];
    $form['tab-content']['fulltext']['notes'] = [
      '#type' => 'markup',
      '#markup' => '',
    ];

    $form['#cache'] = [
      'keys' => ['aaslp_frontpage'],
      'contexts' => ['url'],
      'max-age' => Cache::PERMANENT,
    ];

    $map = '
      <div class="front-map d-flex align-items-center">
        <div class="map-window">
          <p class="map-blurb">
            Browse legal articles in an interactive map. Visualize how slave laws
            in the database were distributed geographically.
          </p>
          <a href="/map" class="btn btn-secondary">
            BROWSE MAP
          </a>
       </div>
      </div>
      ';

    $form['map'] = [
      '#type' => 'markup',
      '#markup' => $map,
    ];

    $sshrc = '
      <div class="row">
        <div class="col-sm-12 sshrc-panel">
          <a href="https://www.sshrc-crsh.gc.ca/" class="panel-img-link">
            <i class="sr-only">Navigate to SSHRC Homepage</i>
            <img class="sshrc-logo" src="/themes/custom/aaslp_lib_unb_ca/images/sshrc.png" alt="SSHRC Logo">
          </a>
        </div>
      </div>
      ';

    // Attach JS.
    $form['#attached']['library'][] = 'aaslp_core/homepage-active-tabs';
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
      $form_state->setErrorByName('input_fulltext', $this->t('Please provide a fulltext search value'));
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

      if ($query) {
        $form_state->setRedirectUrl(
          Url::fromUri("internal:/laws-fulltext?search_api_fulltext=$query")
        );
      }
      else {
        $form_state->setRedirectUrl(
          Url::fromUri("internal:/titles")
        );
      }
    }
    elseif ($op === 'Search/Browse Titles') {
      $query = $this->getQueryFromValue($input_title);

      if ($query) {
        $form_state->setRedirectUrl(
          Url::fromUri("internal:/laws?search_api_fulltext=$query")
        );
      }
      else {
        $form_state->setRedirectUrl(
          Url::fromUri("internal:/laws")
        );
      }
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
