<?php

declare(strict_types=1);

namespace Drupal\custom_form_module\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

/**
 * Configure Custom Form module settings for this site.
 */
final class ResetPassword extends ConfigFormBase {

  /**
   * Method getFormId generate the form unique id.
   *
   * @return string
   *   Form unique id.
   */
  public function getFormId(): string {
    return 'custom_form_module_reset_password';
  }

  /**
   * Method getEditableConfigNames config setting.
   *
   * @return array
   *   Configuration setting.
   */
  protected function getEditableConfigNames(): array {
    return ['custom_form_module.reset_password'];
  }

  /**
   * Method buildForm build the form.
   *
   * @param array $form
   *   Form.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   Form state.
   *
   * @return array []
   *   Form.
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['user_id'] = [
      '#type' => 'number',
      '#title' => $this->t('User ID'),
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * Method generateUrl generates the one time login link to reset the password.
   *
   * @param array $form
   *   Form.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   Form status.
   */
  public function generateUrl(array &$form, FormStateInterface $form_state) {
    $uid = $form_state->getValue('user_id');
    $user = User ::load($uid);
    if ($user) {
      $reset_password_link = user_pass_reset_url($user);
      $result = $this->t('<a href = "@link">Reset password one time login link.</a>', ['@link' => $reset_password_link]);
    }
    else {
      $result = $this->t('User not found.');
    }

    return $result;
  }

  /**
   * Method submitForm submit the form.
   *
   * @param array $form
   *   Form.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   Form state.
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->messenger()->addStatus($this->generateUrl($form, $form_state));
    parent::submitForm($form, $form_state);
  }

}
