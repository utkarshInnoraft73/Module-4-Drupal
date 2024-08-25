<?php

namespace Drupal\color_picker\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'RGB color picker formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "color_picker_rgb_color_picker_formatter",
 *   label = @Translation("RGB color picker formatter"),
 *   field_types = {"color_picker_rgb_color_picker"},
 * )
 */
class RgbColorPickerFormatterFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $elements = [];
    $current_user = \Drupal::currentUser();
    if ($current_user->hasPermission('view rgb field')) {
      foreach ($items as $delta => $item) {
        $elements[$delta] = [
          '#markup' => $this->t('Color is: RGB(@r, @g, @b)', [
            '@r' => $item->r,
            '@g' => $item->g,
            '@b' => $item->b,
          ]),
        ];
      }
    }
    else {
      $elements[] = ['#markup' => $this->t('Access denied')];
    }

    return $elements;
  }

}
