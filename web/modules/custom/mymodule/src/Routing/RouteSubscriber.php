<?php

namespace Drupal\mymodule\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * Method alterRoutes to alter the route.
   *
   * @param Symfony\Component\Routing\RouteCollection $collection
   *   Collections of route.
   */
  protected function alterRoutes(RouteCollection $collection) {

    if ($route = $collection->get('mymodule.simplecontent')) {
      $route->setRequirements([
        '_role' => 'administrator',
        '_permission' => 'access custom permission',
      ]);
    }
  }

}
