<?php

namespace Drupal\custom_event_dashboard\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * CustomEventDashboardController create a dashboard for the 'Events' content.
 */
class CustomEventDashboardController extends ControllerBase {

  /**
   * The database object.
   *
   * @var Drupal\Core\Database\Connection
   */
  protected $database;

  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * Method create.
   *
   * @param Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Object of class ContainerInterface.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * Build the text for the event dashboard page.
   *
   * @return array
   *   Return the element array.
   */
  public function build() : array {
    $elements = [];
    $elements[] = $this->getEventsByYear();
    $elements[] = $this->getEventsByQuaterly();
    $elements[] = $this->getEventsByType();
    return $elements;
  }

  /**
   * Method getEventsByYear to get the event data yearly.
   *
   * @return array
   *   Return the result in the form of markup array.
   */
  public function getEventsByYear() : array {
    $query = $this->database->select('node__field_event_date', 'ned');
    $query->addEXpression('COUNT(ned.entity_id)', 'count');
    $query->addExpression('YEAR(ned.field_event_date_value)', 'year');
    $query->groupBy('year');

    $result = $query->execute()->fetchAll();

    $output = '<h3>Events by year</h3><ul>';
    foreach ($result as $results) {
      $output .= "<li>{$results->year}: {$results->count}</li>";
    }
    $output .= '</ul>';

    return ['#markup' => $output];
  }

  /**
   * Method getEventsByQuaterly to get the event data quarterly.
   *
   * @return array
   *   Return the event data in the form of markup array.
   */
  public function getEventsByQuaterly() : array {
    $query = $this->database->select('node__field_event_date', 'ned');
    $query->addExpression('COUNT(ned.entity_id)', 'count');
    $query->addExpression('QUARTER(ned.field_event_date_value)', 'quarter');
    $query->groupBy('quarter');

    $result = $query->execute()->fetchALl();

    $output = '<h3>Events by year</h3><ul>';
    foreach ($result as $results) {
      $output .= "<li>Quarter {$results->quarter}: {$results->count}</li>";
    }
    $output .= '</ul>';

    return ['#markup' => $output];
  }

  /**
   * Method getEventsByType to get the event data type wise.
   *
   * @return array
   *   Return the event data in the form of markup array.
   */
  public function getEventsByType() {
    $query = $this->database->select('node__field_event_type', 'nfet');
    $query->addExpression('COUNT(nfet.field_event_type_target_id)', 'count');
    $query->join('taxonomy_term_field_data', 'ttfd', 'ttfd.tid = nfet.field_event_type_target_id');
    $query->fields('ttfd', ['name']);
    $query->groupBy('ttfd.name');

    $result = $query->execute()->fetchAll();

    $output = '<h3>Events by type</h3><ul>';
    foreach ($result as $results) {
      $output .= "<li>{$results->name}: {$results->count}</li>";
    }
    $output .= '</ul>';

    return ['#markup' => $output];
  }

}
