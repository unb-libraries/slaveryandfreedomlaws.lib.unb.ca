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

    $form['text'] = [
      '#type' => 'text_format',
      '#format'=> 'unb_libraries',
      '#title' => $this->t('Enter Recently Updated text:'),
      '#default_value' => $config->get('general.text'),
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
      ->set('general.text', $form_state->getValue('text'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
