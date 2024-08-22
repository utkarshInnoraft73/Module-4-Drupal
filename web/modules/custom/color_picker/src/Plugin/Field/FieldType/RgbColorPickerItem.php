<?php

namespace Drupal\color_picker\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'color_picker_rgb_color_picker' field type.
 *
 * @FieldType(
 *   id = "color_picker_rgb_color_picker",
 *   label = @Translation("RGB color picker"),
 *   description = @Translation("Some description."),
 *   default_widget = "color_picker_rgb_color_picker_widget",
 *   default_formatter = "color_picker_rgb_color_picker_formatter",
 * )
 */
class RgbColorPickerItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    $r = $this->get('r')->getValue();
    $g = $this->get('g')->getValue();
    $b = $this->get('b')->getValue();
    return $r === NULL && $g === NULL && $b === NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {
    $properties['hex'] = DataDefinition::create('string')
      ->setLabel(t('Hex Code'));

    $properties['r'] = DataDefinition::create('integer')
      ->setLabel(t('Red'))
      ->setRequired(TRUE);

    $properties['g'] = DataDefinition::create('integer')
      ->setLabel(t('Green'))
      ->setRequired(TRUE);

    $properties['b'] = DataDefinition::create('integer')
      ->setLabel(t('Blue'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition): array {
    $columns = [
      'r' => [
        'type' => 'int',
        'not null' => FALSE,
        'description' => 'Color code of red.',
      ],
      'g' => [
        'type' => 'int',
        'not null' => FALSE,
        'description' => 'Color code of green.',
      ],
      'b' => [
        'type' => 'int',
        'not null' => FALSE,
        'description' => 'Color code of blue.',
      ],
    ];

    $schema = ['columns' => $columns];
    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public function setValue($values, $notify = TRUE) {
    if (isset($values['hex']) && preg_match('/^#?[0-9A-Fa-f]{6}$/', $values['hex'])) {
      $hex = ltrim($values['hex'], '#');
      $values['r'] = hexdec(substr($hex, 0, 2));
      $values['g'] = hexdec(substr($hex, 2, 2));
      $values['b'] = hexdec(substr($hex, 4, 2));
    }

    parent::setValue($values, $notify);
  }

}
