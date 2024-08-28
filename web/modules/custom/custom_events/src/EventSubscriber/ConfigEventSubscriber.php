<?php

namespace Drupal\custom_events\EventSubscriber;

use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * ConfigEventSubscriber custom event subscriber.
 */
class ConfigEventSubscriber implements EventSubscriberInterface {

  /**
   * Method getSubscribedEvents.
   *
   * @return array
   *   The event names to listen for, and the methods that should be executed.
   */
  public static function getSubscribedEvents() {
    return [
      ConfigEvents::SAVE => 'configSave',
      ConfigEvents::DELETE => 'configDelete',
    ];
  }

  public function configSave(ConfigCrudEvent $event) : void {
    $config = $event->getConfig();
    \Drupal::messenger()->addStatus('Saved Config: ' . $config->getName());
  }

  /**
   * Method configDelete.
   *
   * @param Drupal\Core\Config\ConfigCrudEvent $event
   *  [E  xplicite description]
   *
   * @return void
   */
  public function configDelete(ConfigCrudEvent $event) : void {
    $config = $event->getConfig();
    \Drupal::messenger()->addStatus('Deleted Config: ' . $config->getName());
  }


}
