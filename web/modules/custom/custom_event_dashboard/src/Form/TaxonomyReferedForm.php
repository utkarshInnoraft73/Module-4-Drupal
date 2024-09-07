<?php

namespace Drupal\custom_event_dashboard\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Custom event dashboard form.
 */
class TaxonomyReferedForm extends FormBase {
  /**
   * Database object.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * Method create.
   *
   * @param Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Dependency injection container.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * Getter method to the form ID.
   *
   * @return string
   *   Return the form ID.
   */
  public function getFormId(): string {
    return 'custom_event_dashboard_taxonomy_refered';
  }

  /**
   * Method buildForm to build the form that will accept the taxonomy term only.
   *
   * @param array $form
   *   The primary structure that represents the form's components and
   *   configuration.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   This object provides methods to get, set, and manage form values and
   *   other related states.
   *
   * @return array
   *   Return the form elements in the form of array.
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['my_taxonomy_reference_field'] = [
      '#type' => 'entity_autocomplete',
      '#target_type' => 'taxonomy_term',
      '#title' => $this->t('My taxonomy reference field'),
      '#description' => $this->t('The taxonomy term available on the site.'),
      '#tags' => TRUE,
      '#weight' => '0',
    ];

    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Send'),
      ],
    ];

    if ($form_state->get('results')) {
      $results = $form_state->get('results');

      $form['results'] = [
        '#type' => 'details',
        '#title' => $this->t('Query Results'),
        '#open' => TRUE,
        '#weight' => '1',
      ];

      // Group results by term to display tid and uuid once.
      $terms = [];

      foreach ($results as $result) {
        $terms[$result->tid]['uuid'] = $result->uuid;
        $terms[$result->tid]['nodes'][] = [
          'title' => !empty($result->title) ? $result->title : '',
          'url' => !empty($result->nid) ? $this->buildNodeUrl($result->nid) : '#',
          'url_text' => !empty($result->nid) ? $this->t('View Node') : $this->t('No URL available'),
        ];
      }

      // Loop through each term and display its details.
      foreach ($terms as $tid => $term_data) {
        $form['results']["term_$tid"] = [
          '#type' => 'item',
          '#markup' => $this->t(
            '<strong>Term ID:</strong> @tid<br>
             <strong>UUID:</strong> @uuid<br>',
            [
              '@tid' => $tid,
              '@uuid' => $term_data['uuid'],
            ]
          ),
        ];
        // Now display the nodes related to the term.
        foreach ($term_data['nodes'] as $index => $node) {
          $form['results']["term_{$tid}_node_$index"] = [
            '#type' => 'item',
            '#markup' => $this->t(
              '<strong>Node Title:</strong> @title<br>
               <strong>Node URL:</strong> <a href="@url">@url_text</a>',
              [
                '@title' => $node['title'],
                '@url' => $node['url'],
                '@url_text' => $node['url_text'],
              ]
            ),
          ];
        }
      }
    }

    return $form;
  }

  /**
   * Method submitForm trigger at the time of submit form.
   *
   * @param array $form
   *   The primary structure that represents the form's components and
   *   configuration.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   This object provides methods to get, set, and manage form values and
   *   other related states.
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->getTaxonomyTermData($form, $form_state);
    $form_state->setRebuild(TRUE);
  }

  /**
   * Method getTaxonomyTermData to run the query and set the data.
   *
   * @param array $form
   *   The primary structure that represents the form's components and
   *   configuration.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   This object provides methods to get, set, and manage form values and
   *   other related states.
   */
  public function getTaxonomyTermData(array &$form, FormStateInterface $form_state) {

    $term_name = $form_state->getValue('my_taxonomy_reference_field');

    // Database queries to select and display the taxonomy term related data.
    $query = $this->database->select('taxonomy_term_field_data', 'ttfd');
    $query->join('taxonomy_term_data', 'ttd', 'ttd.tid = ttfd.tid');
    $query->fields('ttd', ['tid', 'uuid']);

    // Adding a left join with taxonomy_index to get node references, if they exist.
    $query->leftJoin('taxonomy_index', 'ti', 'ti.tid = ttd.tid');

    // Adding a left join with node_field_data to get node title and nid, if nodes are referencing the term.
    $query->leftJoin('node_field_data', 'nfd', 'nfd.nid = ti.nid');
    $query->fields('nfd', ['title', 'nid']);

    // Filtering by the term ID.
    $query->condition('ttfd.tid', $term_name[0]['target_id']);

    // Execute the query and fetch all results.
    $results = $query->execute()->fetchAll();

    // Setting the data.
    $form_state->set('results', $results);
  }

  /**
   * Helper function to build the node URL.
   *
   * @param string $nid
   *   The node ID.
   *
   * @return string
   *   The URL of the node.
   */
  protected function buildNodeUrl(string $nid): string {
    return \Drupal::service('path_alias.manager')->getAliasByPath('/node/' . $nid);
  }

}
