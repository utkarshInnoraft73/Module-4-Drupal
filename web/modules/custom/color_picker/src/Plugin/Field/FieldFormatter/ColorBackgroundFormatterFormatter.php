<?php

// namespace Drupal\color_picker\Plugin\Field\FieldFormatter;

// use Drupal\Core\Field\FieldItemListInterface;
// use Drupal\Core\Field\FormatterBase;

// /**
//  * Plugin implementation of the 'Color background formatter' formatter.
//  *
//  * @FieldFormatter(
//  *   id = "color_picker_color_background_formatter",
//  *   label = @Translation("Color background formatter"),
//  *   field_types = {"color_picker_rgb_color_picker"},
//  * )
//  */
// class ColorBackgroundFormatterFormatter extends FormatterBase {

//   /**
//    * {@inheritdoc}
//    */
//   public function viewElements(FieldItemListInterface $items, $langcode): array {
//     $element = [];
//     foreach ($items as $delta => $item) {
//       $hex_color = $this->convertRgbToHex($item);
//       $element[$delta] = [
//         '#markup' => '<div style="background-color: red' . $hex_color . '; padding: 10px; color: #fff;">' . $this->t('Color Sample') . '</div>',
//         '#allowed_tags' => ['div'],
//       ];
//     }
//     return $element;
//   }

//   private function convertRgbToHex($item): string {
//     if (isset($item->r) && isset($item->g) && isset($item->b)) {
//       return sprintf('#%02X%02X%02X', $item->r, $item->g, $item->b);
//     }
//     return '#000000';
//   }

// }


namespace Drupal\color_picker\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'Color background formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "color_picker_color_background_formatter",
 *   label = @Translation("Color background formatter"),
 *   field_types = {"color_picker_rgb_color_picker"},
 * )
 */
class ColorBackgroundFormatterFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];
    foreach ($items as $delta => $item) {
      // Use the hex color directly as entered by the user.
      $hex_color = !empty($item->hex) ? $item->hex : '#000000'; // Default to black if no color is provided.
      $element[$delta] = [
        '#markup' => '<div style="background-color: ' . $hex_color . '; padding: 10px; color: #fff;">' . $ . '</div>',
        '#allowed_tags' => ['div'],
      ];
    }
    return $element;
  }
}
