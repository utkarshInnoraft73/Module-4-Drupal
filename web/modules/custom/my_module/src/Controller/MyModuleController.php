<?php

namespace Drupal\my_module\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * MyModuleController.
 */
class MyModuleController extends ControllerBase {

  /**
   * Method showText.
   *
   * @return array
   *   Return the array.
   */
  public function showText() : array {

    return [
      '#type' => 'markup',
      '#markup' => $this->t("Hello"),
    ];
  }

}
