<?php

namespace Drupal\my_example_custom_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a welcome user block.
 *
 * @Block(
 *   id = "my_example_custom_module_welcome_user_block",
 *   admin_label = @Translation("Welcome User Block"),
 *   category = @Translation("Custom"),
 * )
 */
class WelcomeUserBlockBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The current user service.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructs a new WelcomeUserBlockBlock.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Session\AccountProxyInterface $currentUser
   *   The current user service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountProxyInterface $currentUser) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $currentUser;
  }

  /**
   * Method create.
   *
   * @param Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Container services.
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   *
   * @return object
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) : object {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user')
    );
  }

  /**
   * Method build.
   *
   * @return array
   *   Return build array.
   */
  public function build() : array {
    $userRoles = $this->currentUser->getRoles();
    $welcomeText = "Welcome ";
    $welcomeText .= implode(', ', $userRoles);

    return [
      '#type' => 'markup',
      '#markup' => '<div class = "welcome-text">' . $welcomeText . '</div>',
      '#cache' => [
        'contexts' => ['user.roles'],
        'tags' => ['user:' . $this->currentUser->id()],
      ],
      '#attached' => [
        'library' => [
          'my_example_custom_module/my_example_custom_module_css',
        ],
      ],
    ];
  }

}
