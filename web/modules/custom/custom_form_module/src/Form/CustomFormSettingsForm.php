<?php

namespace Drupal\custom_form_module\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * CustomFormSettingsForm Class is for set the custom form cofiguration setting.
 */
class CustomFormSettingsForm extends ConfigFormBase {

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'custom_form.custom_module_config_form';

  /**
   * Method getFormId.
   *
   * @return string
   *   Form Id.
   */
  public function getFormId() : string {
    return 'custom_module_config_form';

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

    $form['full_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Full Name'),
      '#default_value' => $config->get('full_name'),
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email ID'),
      '#default_value' => $config->get('email'),
      '#required' => TRUE,
    ];

    $form['country_code'] = [
      '#type' => 'select',
      '#title' => $this->t('Country Code'),
      '#options' => [
        '91' => $this->t('+91 (India)'),
      ],
      '#required' => TRUE,
    ];

    $form['phone_number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Phone Number'),
      '#required' => TRUE,
      '#maxlength' => 10,
    ];

    $form['gender'] = [
      '#type' => 'radios',
      '#title' => $this->t('Gender'),
      '#options' => [
        'male' => $this->t('Male'),
        'female' => $this->t('Female'),
        'other' => $this->t('Other'),
      ],
      '#default_value' => 'male',
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

    // Validate phone number.
    $phone_number = $form_state->getValue('phone_number');
    if (!preg_match('/^[6-9][0-9]{9}$/', $phone_number)) {
      $form_state->setErrorByName('phone_number',
      $this->t('Invalid phone number! Please enter 10-digit Indian phone number.')
      );
    }

    // Validate email.
    $email = $form_state->getValue('email');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $form_state->setErrorByName('email',
      $this->t('The email address is not valid.')
      );
    }

    $public_domains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com'];
    $email_domain = substr(strrchr($email, "@"), 1);
    if (!in_array($email_domain, $public_domains)) {
      $form_state->setErrorByName('email',
      $this->t('The email domain must be one of the following: gmail.com, yahoo.com, outlook.com, hotmail.com.')
      );
    }

    if (substr($email, -4) !== '.com') {
      $form_state->setErrorByName('email',
      $this->t('Only .com email addresses are allowed.')
      );
    }

    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config(static::SETTINGS)
      ->set('full_name', $form_state->getValue('full_name'))
      ->set('phone', $form_state->getValue('phone'))
      ->set('email', $form_state->getValue('email'))
      ->set('gender', $form_state->getValue('gender'))
      ->save();

    parent::submitForm($form, $form_state);
    \Drupal::messenger()->addMessage(
      $this->t('Configuration saved successfully.')
    );
  }

}
