<?php

declare(strict_types=1);

namespace Drupal\custom_movie\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure the movie budget friendly price.
 */
final class SettingsForm extends ConfigFormBase {

  /**
   * Method getFormId to get the form ID.
   *
   * @return string
   *   Form id.
   */
  public function getFormId(): string {
    return 'custom_movie_settings';
  }

  /**
   * Method getEditableConfigNames.
   *
   * @return array
   *   Editable config form name.
   */
  protected function getEditableConfigNames(): array {
    return ['custom_movie.settings'];
  }

  /**
   * Method buildForm to buid the form.
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
    $form['price'] = [
      '#type' => 'number',
      '#title' => $this->t('Budget friendly amount'),
      '#default_value' => $this->config('custom_movie.settings')->get('price'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * Method submitForm to submit the form.
   *
   * @param array $form
   *   Form.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   Form State.
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('custom_movie.settings')
      ->set('price', $form_state->getValue('price'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
