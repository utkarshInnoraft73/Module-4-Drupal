<?php

namespace Drupal\custom_movie\EventSubscriber;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class to subscribe the event this class compair the prices.
 */
class MovieNodeViewSubscriber implements EventSubscriberInterface {

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected ConfigFactoryInterface $configFactory;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected EntityTypeManagerInterface $entityTypeManager;

  /**
   * The messenger.
   *
   * @var Drupal\Core\Messenger\MessengerInterface
   */
  protected MessengerInterface $messenger;

  /**
   * Constructs a new MoviePriceComparisonSubscriber object.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messanger.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   */
  public function __construct(MessengerInterface $messenger, ConfigFactoryInterface $config_factory) {
    $this->messenger = $messenger;
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      KernelEvents::VIEW => ['onNodeView', 10],
    ];
  }

  /**
   * Display messages based on the movie's budget comparison.
   */
  public function onNodeView(): void {
    $route_match = \Drupal::routeMatch();
    $node = $route_match->getParameter('node');
    if ($node && $node->getType() === 'movie') {
      // Get the budget-friendly amount from the configuration form.
      $config = $this->configFactory->get('custom_movie.settings');
      $config_budget = (float) $config->get('price');
      $movie_price = (float) $node->get('field_movie_price')->value;

      // Compare movie price with the configured budget and display messages.
      if ($movie_price > $config_budget) {
        $this->messenger->addWarning(t('The movie is over budget.'));
      }
      elseif ($movie_price < $config_budget) {
        $this->messenger->addStatus(t('The movie is under budget.'));
      }
      else {
        $this->messenger->addStatus(t('The movie is within budget.'));
      }
    }
  }

}
