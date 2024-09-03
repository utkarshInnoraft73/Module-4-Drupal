<?php

namespace Drupal\custom_movie\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\custom_movie\Entity\AwardWinningMovie;

/**
 * Award winning Movie form.
 */
class AwardWinningMovieForm extends EntityForm {

  /**
   * Method form to build the form.
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
  public function form(array $form, FormStateInterface $form_state): array {

    $form = parent::form($form, $form_state);

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Movie name'),
      '#maxlength' => 255,
      '#default_value' => $this->entity->label(),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#machine_name' => [
        'exists' => [AwardWinningMovie::class, 'load'],
      ],
      '#disabled' => !$this->entity->isNew(),
    ];

    $form['year'] = [
      '#type' => 'select',
      '#title' => $this->t('Winning year'),
      '#options' => array_combine(range(1947, 2024), range(1947, 2024)),
      '#default_value' => $this->entity->getYear(),
    ];

    return $form;
  }

  /**
   * Method save to save the form changes.
   *
   * @param array $form
   *   The primary structure that represents the form's components and
   *   configuration.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   This object provides methods to get, set, and manage form values and
   *   other related states.
   *
   * @return int
   */
  public function save(array $form, FormStateInterface $form_state): int {
    $result = parent::save($form, $form_state);
    $message_args = ['%label' => $this->entity->label()];
    $this->messenger()->addStatus(
      match($result) {
        \SAVED_NEW => $this->t('New movie added %label.', $message_args),
        \SAVED_UPDATED => $this->t('Updated movie %label.', $message_args),
      }
    );
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
    return $result;
  }

}
