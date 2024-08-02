<?php

namespace Drupal\mymodule\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;

/**
 * MyModuleController the controller class for the mymodule routing.
 */
class MyModuleController extends ControllerBase {

  /**
   * Method simpleContent.
   *
   * @return array
   *   MarkUp.
   */
  public function simpleContent() : array {

    return [
      '#type' => 'markup',
      '#markup' => $this->t("Welcome Sir."),
    ];
  }

  /**
   * Checks access for a specific request.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Run access checks for this account.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function access(AccountInterface $account) {
    // Check if the user has the 'access custom permission' permission
    // and if the user has the 'authenticated' role.
    $hasPermission = $account->hasPermission('access custom permission');
    $hasAuthenticatedRole = in_array('authenticated', $account->getRoles());

    return AccessResult::allowedIf($hasPermission && $hasAuthenticatedRole);
  }

  /**
   * Method parameterContent.
   *
   * @param int $id
   *   Custom parameter accessing from the url.
   *
   * @return array
   *   Markup.
   */
  public function parameterContent(int $id) : array {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Your Parameter given in url is: @id', ['@id' => $id]),
    ];
  }

}
