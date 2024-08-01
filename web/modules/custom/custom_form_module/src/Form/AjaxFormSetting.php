<?php

declare(strict_types=1);

namespace Drupal\custom_form_module\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class AjaxFormSetting to manage the configuration AJAX form for the site.
 */
final class AjaxFormSetting extends ConfigFormBase {

  /**
   * Method getFormId Form unique id.
   *
   * @return string
   *   Form unique id.
   */
  public function getFormId(): string {
    return 'custom_form_module_ajax_setting';
  }

  /**
   * Method getEditableConfigNames editable form config names.
   *
   * @return array
   *   Form editable config name.
   */
  protected function getEditableConfigNames(): array {
    return ['custom_form_module.custom_form_module_ajax_setting'];
  }

  /**
   * Method buildForm to buid the configuration Ajax form.
   *
   * @param array $form
   *   Form.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   Form state.
   *
   * @return array
   *   Form fields.
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    // Full name field.
    $form['full_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Full Name'),
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::validateFullNameAjax',
        'event' => 'change',
      ],
    ];
    $form['full_name_error'] = [
      '#type' => 'markup',
      '#markup' => '<div id="full-name-error" class="error-message"></div>',
    ];

    // Email field.
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email ID'),
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::validateEmailAjax',
        'event' => 'change',
      ],
    ];

    $form['email_error'] = [
      '#type' => 'markup',
      '#markup' => '<div id="email-error" class="error-message"></div>',
    ];

    // Country code.
    $form['country_code'] = [
      '#type' => 'select',
      '#title' => $this->t('Country Code'),
      '#options' => [
        '91' => $this->t('+91 (India)'),
      ],
      '#required' => TRUE,
    ];

    // Phone number.
    $form['phone_number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Phone Number'),
      '#required' => TRUE,
      '#maxlength' => 10,
      '#ajax' => [
        'callback' => '::validatePhoneNumberAjax',
        'event' => 'change',
      ],
    ];

    $form['phone_number_error'] = [
      '#type' => 'markup',
      '#markup' => '<div id="phone-number-error" class="error-message"></div>',
    ];

    // Gender field.
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

    $form['#attached']['library'][] = 'custom_form_module/custom_form_module_css';
    return parent::buildForm($form, $form_state);
  }

  /**
   * Method validateFullNameAjax to ajax validate of full name.
   *
   * @param array $form
   *   Form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Form state.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   AJAX response of for the field full name.
   */
  public function validateFullNameAjax(array &$form, FormStateInterface $form_state): AjaxResponse {
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
   * Method validatePhoneNumberAjax to AJAX validate the phone number.
   *
   * @param array $form
   *   Form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Form state.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   AJAX response of for the field phone number.
   */
  public function validatePhoneNumberAjax(array &$form, FormStateInterface $form_state): AjaxResponse {
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
   * Method validateEmailAjax to ajax validate email.
   *
   * @param array $form
   *   Form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Form state.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   AJAX response of for the field email.
   */
  public function validateEmailAjax(array &$form, FormStateInterface $form_state): AjaxResponse {
    $response = new AjaxResponse();
    $email = $form_state->getValue('email');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $message = $this->t('The email address is not valid.');
      $response->addCommand(new HtmlCommand('#email-error', $message));
    }

    else {
      $public_domains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com'];
      $email_domain = explode('@', $email)[1];
      if (!in_array($email_domain, $public_domains)) {
        $message = $this->t('The email domain must be one of the following: gmail.com, yahoo.com, outlook.com, hotmail.com.');
        $response->addCommand(new HtmlCommand('#email-error', $message));
      }

      else {
        $response->addCommand(new HtmlCommand('#email-error', ''));
      }

    }
    return $response;
  }

  /**
   * Method validateForm to validate at the time of submit.
   *
   * @param array $form
   *   Form.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   Form state.
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
    // $email_domain = substr(strrchr($email, "@"), 1);
    $email_domain = explode('@', $email)[1];

    if (!in_array($email_domain, $public_domains)) {
      $form_state->setErrorByName('email',
      $this->t('The email domain must be one of the following: gmail.com, yahoo.com, outlook.com, hotmail.com.')
      );
    }

    parent::validateForm($form, $form_state);
  }

  /**
   * Method submitForm to submit the form.
   *
   * @param array $form
   *   Form.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   Form state.
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('custom_form_module.settings')
      ->set('full_name', $form_state->getValue('full_name'))
      ->set('email', $form_state->getValue('email'))
      ->set('country_code', $form_state->getValue('country_code'))
      ->set('phone_number', $form_state->getValue('phone_number'))
      ->set('gender', $form_state->getValue('gender'))
      ->save();
    parent::submitForm($form, $form_state);

  }

}
