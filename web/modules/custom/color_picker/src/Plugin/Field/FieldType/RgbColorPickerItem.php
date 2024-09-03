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
 *   description = @Translation("Field to take color code."),
 *   default_widget = "color_picker_rgb_color_picker_widget",
 *   default_formatter = "color_picker_rgb_color_picker_formatter",
 * )
 */
class RgbColorPickerItem extends FieldItemBase {

  /**
   * Method isEmpty.
   *
   * @return bool
   *   Return TRUE if any of field is null.
   */
  public function isEmpty(): bool {
    $r = $this->get('r')->getValue();
    $g = $this->get('g')->getValue();
    $b = $this->get('b')->getValue();
    return $r === NULL && $g === NULL && $b === NULL;
  }

  /**
   * Method propertyDefinitions to set the property.
   *
   * @param Drupal\Core\Field\FieldStorageDefinitionInterface $field_definition
   *   [Explicite description].
   *
   * @return array
   *   Return the propertise arrar for the field.
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {
    $properties['hex'] = DataDefinition::create('string')
      ->setLabel(t('Hex Code'));

    $properties['r'] = DataDefinition::create('string')
      ->setLabel(t('Red'))
      ->setRequired(TRUE);

    $properties['g'] = DataDefinition::create('string')
      ->setLabel(t('Green'))
      ->setRequired(TRUE);

    $properties['b'] = DataDefinition::create('string')
      ->setLabel(t('Blue'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * Method schema.
   *
   * @param Drupal\Core\Field\FieldStorageDefinitionInterface $field_definition
   *   [Explicite description].
   *
   * @return array
   *   The schema.
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition): array {
    $columns = [
      'r' => [
        'type' => 'text',
        'not null' => FALSE,
        'description' => 'Color code of red.',
      ],
      'g' => [
        'type' => 'text',
        'not null' => FALSE,
        'description' => 'Color code of green.',
      ],
      'b' => [
        'type' => 'text',
        'not null' => FALSE,
        'description' => 'Color code of blue.',
      ],
    ];

    $schema = ['columns' => $columns];
    return $schema;
  }

  /**
   * Method setValue.
   *
   * @param array|null $values
   *   [Explicite description].
   * @param bool $notify
   *   [Explicite description].
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
