<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * To show the hello text.
 */
class ShowTextController extends ControllerBase {

  /**
   * Protect currentUser.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Method __construct.
   *
   * @param Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current logged in user.
   */
  public function __construct(AccountProxyInterface $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * Method create to inject the dependency.
   *
   * @param Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Container that current_user service.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user')
    );
  }

  /**
   * Method showText to show the custom text.
   *
   * @return array
   *   Text to show the "Hello [User Name]".
   */
  public function showText() : array {
    $user = $this->currentUser();
    if ($this->currentUser->hasPermission('custom_permission')) {

      return [
        '#type' => 'markup',
        '#markup' => $this->t("Hello") . " " . $user->getDisplayName(),
        '#cache' => [
          'tags' => ['user:' . $this->currentUser()->id()],
        ],
      ];
    }
    return [
      '#type' => 'markup',
      '#markup' => 'No Permission',
      '#cache' => [
        'tags' => ['user:' . $this->currentUser->id()],
      ],
    ];
  }

}
