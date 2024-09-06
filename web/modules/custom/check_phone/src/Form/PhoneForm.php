<?php

namespace Drupal\check_phone\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a Check phone form.
 */
class PhoneForm extends FormBase {

  /**
   * Method getFormId to get the form unique ID.
   *
   * @return string
   *   The form unique ID.
   */
  public function getFormId(): string {
    return 'check_phone_phone';
  }

  /**
   * Method buildForm to build the simple form for the phone number input.
   *
   * @param array $form
   *   The primary structure that represents the form's components and
   *   configuration.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   This object provides methods to get, set, and manage form values and
   *   other related states.
   *
   * @return array
   *   Return the form elements in the form of array.
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['phone'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Phone number'),
      '#required' => TRUE,
      '#attributes' => [
        'id' => 'edit-phone-format',
        'placeholder' => '(xxx) xxx xxxx',
      ],
    ];

    $form['#attached']['library'] = 'check_phone/check_phone.phone_format_library';
    return $form;
  }

  /**
   * Method submitForm to submit the form.
   *
   * @param array $form
   *   The primary structure that represents the form's components and
   *   configuration.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   This object provides methods to get, set, and manage form values and
   *   other related states.
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->messenger()->addStatus($this->t('The message has been sent.'));
  }

}
