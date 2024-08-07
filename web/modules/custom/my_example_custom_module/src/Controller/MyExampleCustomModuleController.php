<?php

declare(strict_types=1);

namespace Drupal\my_example_custom_module\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for my_example_custom_module routes.
 */
final class MyExampleCustomModuleController extends ControllerBase {

  /**
   * Method customText to return the custom text on the web page.
   *
   * @return array
   *   Return the $markup.
   */
  public function customText(): array {

    $current_user = \Drupal::currentUser();
    $user = ($current_user->getDisplayName() == 'Anonymous') ? 'User Not logged in.' : 'You are welcome ' . ucfirst($current_user->getDisplayName()) . ".";
    $build['content'] = [
      '#type' => 'item',
      '#markup' => $user,
    ];

    return $build;
  }

}
