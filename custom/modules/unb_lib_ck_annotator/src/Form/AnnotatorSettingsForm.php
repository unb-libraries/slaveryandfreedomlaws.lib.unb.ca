<?php

namespace Drupal\unb_lib_ck_annotator\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class AnnotatorSettingsForm extends ConfigFormBase {

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'unb_lib_ck_annotator.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'unb_lib_ck_annotator_admin_settings';
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

    $form['group_numbered_enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable numbered annotations'),
      '#default_value' => $config->get('groups.numbered.enabled'),
    ];

    $form['group_numbered_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label for numbered annotations'),
      '#default_value' => $config->get('groups.numbered.label'),
    ];

    $form['group_lowercase_enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable lowercase annotations'),
      '#default_value' => $config->get('groups.lowercase.enabled'),
    ];

    $form['group_lowercase_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label for lowercase annotations'),
      '#default_value' => $config->get('groups.lowercase.label'),
    ];

    $form['group_uppercase_enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable uppercase annotations'),
      '#default_value' => $config->get('groups.uppercase.enabled'),
    ];

    $form['group_uppercase_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label for uppercase annotations'),
      '#default_value' => $config->get('groups.uppercase.label'),
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
      ->set('groups.numbered.enabled', $form_state->getValue('group_numbered_enabled'))
      // You can set multiple configurations at once by making
      // multiple calls to set().
      ->set('groups.numbered.label', $form_state->getValue('group_numbered_label'))
      // Remaining values.
      ->set('groups.lowercase.enabled', $form_state->getValue('group_lowercase_enabled'))
      ->set('groups.lowercase.label', $form_state->getValue('group_lowercase_label'))
      ->set('groups.uppercase.enabled', $form_state->getValue('group_uppercase_enabled'))
      ->set('groups.uppercase.label', $form_state->getValue('group_uppercase_label'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
