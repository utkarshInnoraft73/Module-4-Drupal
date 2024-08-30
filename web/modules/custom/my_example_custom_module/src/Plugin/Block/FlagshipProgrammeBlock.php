<?php

namespace Drupal\my_example_custom_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\my_example_custom_module\services\CustomServices;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a flagship programme block.
 *
 * @Block(
 *   id = "my_example_custom_module_flagship_programme",
 *   admin_label = @Translation("Flagship Programme"),
 *   category = @Translation("Custom"),
 * )
 */
class FlagshipProgrammeBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Protected loaddata.
   *
   * @var mixed
   */
  protected $loaddata;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, CustomServices $loaddata) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->loaddata = $loaddata;
  }

  /**
   * Method create.
   *
   * @param CSymfony\Component\DependencyInjection\ContainerInterface $container
   *   [Explicite description].
   * @param array $configuration
   *   [Explicite description].
   * @param string $plugin_id
   *   [Explicite description].
   * @param string $plugin_definition
   *   [Explicite description].
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('my_example_custom_module.db_operations')
    );
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
      '#data' => $this->loaddata->getData(),
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
