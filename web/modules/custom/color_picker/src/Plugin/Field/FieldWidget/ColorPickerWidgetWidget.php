<?php

namespace Drupal\color_picker\Plugin\Field\FieldWidget;

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
    $default_value = ($items[$delta]->hex) ?? '';
    $element['hex'] = [
      '#type' => 'color',
      '#title' => $this->t('Pick a color'),
      '#default_value' => $default_value,
    ];
    return $element;
  }

}
