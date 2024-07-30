<?php

namespace Drupal\custom_form_task_2\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * CustomFormTask2SettingsForm Class is for set the custom form cofig setting.
 */
class CustomFormTask2SettingsForm extends ConfigFormBase {

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'custom_form_task_2.custom_form_task_2_config_form';

  /**
   * Method getFormId.
   *
   * @return string
   *   Form Id.
   */
  public function getFormId() : string {
    return 'custom_form_task_2_config_form';

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
      '#ajax' => [
        'callback' => '::validateFullNameAjax',
        'event' => 'blur',
        'wrapper' => 'full-name-error',
      ],
    ];
    $form['full_name_error'] = [
      '#type' => 'markup',
      '#markup' => '<div id="full-name-error" class="error-message"></div>',
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email ID'),
      '#default_value' => $config->get('email'),
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::validateEmailAjax',
        'event' => 'blur',
        'wrapper' => 'email-error',
      ],
    ];

    $form['email_error'] = [
      '#type' => 'markup',
      '#markup' => '<div id="email-error" class="error-message"></div>',
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
      '#ajax' => [
        'callback' => '::validatePhoneNumberAjax',
        'event' => 'blur',
        'wrapper' => 'phone-number-error',
      ],
    ];

    $form['phone_number_error'] = [
      '#type' => 'markup',
      '#markup' => '<div id="phone-number-error" class="error-message"></div>',
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
   * Method validateFullNameAjax.
   *
   * @param array $form
   *   [Explicite description].
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   [Explicite description].
   *
   * @return object
   *   $response.
   */
  public function validateFullNameAjax(array &$form, FormStateInterface $form_state) : object {
    $response = new AjaxResponse();
    $full_name = $form_state->getValue('full_name');
    if (!preg_match('/^[a-zA-Z\s]+$/', $full_name)) {
      $message = $this->t('Full name can only contain letters and white spaces.');
      $response->addCommand(new HtmlCommand('#full-name-error', $message));
    }
    else {
      $response->addCommand(new HtmlCommand('#full-name-error', ''));
    }
    return $response;
  }

  /**
   * Method validatePhoneNumberAjax.
   *
   * @param array $form
   *   [Explicite description].
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   [Explicite description].
   *
   * @return object
   *   $response.
   */
  public function validatePhoneNumberAjax(array &$form, FormStateInterface $form_state) : object {
    $response = new AjaxResponse();
    $phone_number = $form_state->getValue('phone_number');
    $country_code = $form_state->getValue('country_code');

    if (!preg_match('/^[0-9]{10}$/', $phone_number)) {
      $message = $this->t('Phone number must be a 10-digit number.');
      $response->addCommand(new HtmlCommand('#phone-number-error', $message));
    }
    elseif ($country_code == '91' && !preg_match('/^[6-9][0-9]{9}$/', $phone_number)) {
      $message = $this->t('Indian phone number must start with 6, 7, 8, or 9 and be 10 digits long.');
      $response->addCommand(new HtmlCommand('#phone-number-error', $message));
    }
    else {
      $response->addCommand(new HtmlCommand('#phone-number-error', ''));
    }
    return $response;
  }

  /**
   * Method validateEmailAjax.
   *
   * @param array $form
   *   [Explicite description].
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   [Explicite description].
   *
   * @return object
   *   $response.
   */
  public function validateEmailAjax(array &$form, FormStateInterface $form_state) : object {
    $response = new AjaxResponse();
    $email = $form_state->getValue('email');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $message = $this->t('The email address is not valid.');
      $response->addCommand(new HtmlCommand('#email-error', $message));
    }
    else {
      $public_domains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com'];
      $email_domain = substr(strrchr($email, "@"), 1);
      if (!in_array($email_domain, $public_domains)) {
        $message = $this->t('The email domain must be one of the following: gmail.com, yahoo.com, outlook.com, hotmail.com.');
        $response->addCommand(new HtmlCommand('#email-error', $message));
      }
      elseif (substr($email, -4) !== '.com') {
        $message = $this->t('Only .com email addresses are allowed.');
        $response->addCommand(new HtmlCommand('#email-error', $message));
      }
      else {
        $response->addCommand(new HtmlCommand('#email-error', ''));
      }
    }
    return $response;
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
