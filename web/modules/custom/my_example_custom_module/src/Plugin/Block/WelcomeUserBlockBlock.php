<?php

declare(strict_types=1);

namespace Drupal\my_example_custom_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a welcome user block block.
 *
 * @Block(
 *   id = "my_example_custom_module_welcome_user_block",
 *   admin_label = @Translation("Welcome User Block"),
 *   category = @Translation("Custom"),
 * )
 */
final class WelcomeUserBlockBlock extends BlockBase {

  /**
   * Method build to show the markup.
   *
   * @return array
   *   Return the markup.
   */
  public function build(): array {
    $userRole = \Drupal::currentUser()->getRoles();
    $welcomeText = "Welcome ";
    for ($i = 0; $i < count($userRole); $i++) {
      $welcomeText = $welcomeText . " " . $userRole[$i];
    }

    $build = [
      '#markup' => $welcomeText,
    ];
    return $build;
  }

}
