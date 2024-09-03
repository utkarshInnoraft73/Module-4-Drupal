<?php

namespace Drupal\color_picker\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines the 'color_picker_rgb_color_picker_widget' field widget.
 *
 * @FieldWidget(
 *   id = "color_picker_rgb_color_picker_widget",
 *   label = @Translation("RGB color picker"),
 *   field_types = {"color_picker_rgb_color_picker"},
 * )
 */
class RgbColorPickerWidgetWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {
    $element['r'] = [
      '#type' => 'number',
      '#title' => $this->t('Red'),
      '#default_value' => (string) ($items[$delta]->r) ?? '',
    ];

    $element['g'] = [
      '#type' => 'number',
      '#title' => $this->t('Green'),
      '#default_value' => (string) ($items[$delta]->g) ?? '',
    ];

    $element['b'] = [
      '#type' => 'number',
      '#title' => $this->t('Blue'),
      '#default_value' => (string) ($items[$delta]->b) ?? '',
    ];

    return $element;
  }

}
