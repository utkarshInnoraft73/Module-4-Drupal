<?php

namespace Drupal\my_example_custom_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Class my_example_custom_module routes.
 *
 * It is a controller class that will show on the /custom-welcome-page route.
 */
class MyExampleCustomModuleController extends ControllerBase {

  /**
   * Protected account.
   *
   * @var \Drupal\Core\Session\AccountInterface
   *   Account details of the current details.
   */
  protected $account;

  public function __construct(AccountInterface $account) {
    $this->account = $account;
  }

  /**
   * Method customText to return the custom text on the web page.
   *
   * @return array
   *   Return the the cudtom text on the webpage.
   */
  public function customText(): array {
    $current_user = $this->account->getDisplayName();
    $build['content'] = [
      '#type' => 'item',
      '#markup' => t('Current User:') . ucfirst($current_user),
    ];

    return $build;
  }

}
