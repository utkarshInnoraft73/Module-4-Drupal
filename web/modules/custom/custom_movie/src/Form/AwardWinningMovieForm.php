<?php

namespace Drupal\custom_movie\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\custom_movie\Entity\AwardWinningMovie;

/**
 * Award winning Movie config form.
 */
class AwardWinningMovieForm extends EntityForm {

  /**
   * Method form.
   *
   * @param array $form
   *   Form.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   Form state.
   *
   * @return array
   *   Form.
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
   * Method save.
   *
   * @param array $form
   *   Form.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   Form.
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
