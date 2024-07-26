<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class ShowTextController.
 */
class ShowTextController extends ControllerBase {

  /**
   * Method showText.
   *
   * @return array
   *   Text to show the "Hello [User Name]".
   */
  public function showText() : array {
    $user = $this->currentUser();
    if (\Drupal::currentUser()->hasPermission('custom_permission')) {
      $userName = \Drupal::currentUser()->getDisplayName();

      return [
        '#type' => 'markup',
        '#markup' => $this->t("Hello") . $user->getDisplayName(),
        '#cache' => [
          'tags' => ['user:' . $this->currentUser()->id()],
        ],
      ];
    }
    return [
      '#type' => 'markup',
      '#markup' => 'No Permission',
      '#cache' => [
        'tags' => ['user:' . \Drupal::currentUser()->id()],
      ],
    ];
  }

}
