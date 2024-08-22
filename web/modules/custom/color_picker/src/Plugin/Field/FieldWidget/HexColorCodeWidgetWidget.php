<?php

namespace Drupal\color_picker\Plugin\Field\FieldWidget;

use Drupal\Component\Utility\Color;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines the 'color_picker_hex_color_code_widget' field widget.
 *
 * @FieldWidget(
 *   id = "color_picker_hex_color_code_widget",
 *   label = @Translation("Hex color code"),
 *   field_types = {"color_picker_rgb_color_picker"},
 * )
 */
class HexColorCodeWidgetWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {
    $rgb = [
      'r' => $items[$delta]->r ?? 0,
      'g' => $items[$delta]->g ?? 0,
      'b' => $items[$delta]->b ?? 0,
    ];
    $element['hex'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Hex Color'),
      '#default_value' => Color::rgbToHex($rgb),
      '#description' => $this->t('Enter a 6-digit hex code, e.g., #FF5733.'),
      '#attributes' => ['maxlength' => 7],
    ];
    return $element;
  }

}
