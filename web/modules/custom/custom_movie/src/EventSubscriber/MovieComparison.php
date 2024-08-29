<?php

namespace Drupal\custom_movie\EventSubscriber;

use Drupal\entity_events\Event\EntityEvent;
use Drupal\entity_events\EventSubscriber\EntityEventInsertSubscriber;

/**
 * MovieComparison.
 */
class MovieComparison extends EntityEventInsertSubscriber {

  /**
   * Method onEntityInsert.
   *
   * @param Drupal\entity_events\Event\EntityEvent $event
   *   [Explicite description].
   */
  public function onEntityInsert(EntityEvent $event) {
    \Drupal::messenger()->addStatus('Entity inserted ');
  }

}
