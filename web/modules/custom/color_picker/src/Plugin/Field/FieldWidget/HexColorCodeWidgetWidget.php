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
    // Extract RGB values.
    $r = $items[$delta]->r;
    $g = $items[$delta]->g;
    $b = $items[$delta]->b;

    // Determine the default hex value.
    if (!empty($items[$delta]->hex)) {
      $default_hex = $items[$delta]->hex;
    }
    elseif (!empty($r) && !empty($g) && !empty($b)) {
      // If hex is not set, convert RGB to hex if RGB values are available.
      $default_hex = Color::rgbToHex("$r, $g, $b");
    }
    else {
      // If no values are set, use an empty string.
      $default_hex = '';
    }

    $element['hex'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Hex Color'),
      '#default_value' => $default_hex,
      '#description' => $this->t('Enter a 6-digit hex code, e.g., #FF5733.'),
      '#attributes' => ['maxlength' => 7],
    ];
    return $element;
  }

}
