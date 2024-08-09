<?php

namespace Drupal\my_example_custom_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a flagship programme block.
 *
 * @Block(
 *   id = "my_example_custom_module_flagship_programme",
 *   admin_label = @Translation("Flagship Programme"),
 *   category = @Translation("Custom"),
 * )
 */
class FlagshipProgrammeBlock extends BlockBase {

  /**
   * Protected loaddata.
   *
   * @var mixed
   */
  protected $loaddata;

  public function __construct() {
    $this->loaddata = \Drupal::service('my_example_custom_module.db_operations');
  }

  /**
   * Method build to show the data.
   *
   * @return array
   *   The data fetched from the 'my_example_custom_module_flag_ship' table.
   */
  public function build() : array {
    $output[] = $this->loaddata->getData();
    return [
      '#theme' => 'flagship_programme_table',
      '#data' => $output,
      '#attached' => [
        'library' => [
          'my_example_custom_module/my_example_custom_module_css',
        ],
      ],
      '#cache' => [
        'tags' => ['my_example_custom_module_flag_ship'],
      ],
    ];

  }

}
