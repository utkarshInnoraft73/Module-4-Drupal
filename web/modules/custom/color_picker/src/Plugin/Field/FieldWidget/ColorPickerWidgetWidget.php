<?php

namespace Drupal\color_picker\Plugin\Field\FieldWidget;

use Drupal\Component\Utility\Color;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines the 'color_picker_color_picker_widget' field widget.
 *
 * @FieldWidget(
 *   id = "color_picker_color_picker_widget",
 *   label = @Translation("Color Picker"),
 *   field_types = {"color_picker_rgb_color_picker"},
 * )
 */
class ColorPickerWidgetWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {
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
    // $default_value = ($items[$delta]->hex) ?? '';
    $element['hex'] = [
      '#type' => 'color',
      '#title' => $this->t('Pick a color'),
      '#default_value' => $default_hex,
    ];
    return $element;
  }

}
