<?php

declare(strict_types=1);

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
final class FlagshipProgrammeBlock extends BlockBase {

  /**
   * Method build to show the data.
   *
   * @return array
   *   The data fetched from the 'my_example_custom_module_flag_ship' table.
   */
  public function build(): array {

    $connection = \Drupal::database();
    $query = $connection->select('my_example_custom_module_flag_ship', 'm')
      ->fields('m', ['group_name', 'first_label', 'first_lable_value', 'second_label', 'second_label_value'])
      ->execute();
    $results = $query->fetchAll();
    $output = [];
    foreach ($results as $row) {
      $output[] = [
        'group_name' => $row->group_name,
        'first_label' => $row->first_label,
        'first_lable_value' => $row->first_lable_value,
        'second_label' => $row->second_label,
        'second_label_value' => $row->second_label_value,
      ];
    }

    return [
      '#theme' => 'flagship_programme_table',
      '#data' => $output,
      '#attached' => [
        'library' => [
          'my_example_custom_module/flagship_programme_styles',
        ],
      ],
    ];

  }

}
