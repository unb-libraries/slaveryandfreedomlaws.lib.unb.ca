<?php

namespace Drupal\sfl_recently_updated\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure module sfl_recently_updated settings for this site.
 */
class RUTextForm extends ConfigFormBase {

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'sfl_recently_updated.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'sfl_recently_updated_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);
    $text_cfg = $config->get('general.text');

    if ($text_cfg) {
      if (is_array($text_cfg)) {
        $text = $text_cfg['value'];
      }
      else {
        $text = is_string($text_cfg) ?
          $text_cfg :
          ''
        ;
      }
    }
    else {
      $text = '';
    }
    
    $form['#title'] = 'Recently Updated';
 
    $form['text'] = [
      '#type' => 'text_format',
      '#format'=> 'unb_libraries',
      '#title' => $this->t('Edit introduction text:'),
      '#default_value' => $text,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    $this->configFactory->getEditable(static::SETTINGS)
      // Set the submitted configuration setting.
      ->set('general.text', $form_state->getValue('text')['value'])
      ->save();

    parent::submitForm($form, $form_state);
  }

}
