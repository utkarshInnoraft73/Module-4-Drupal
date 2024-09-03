<?php

namespace Drupal\color_picker\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Color;
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
   * Display the static text with background of color code that is user submit.
   *
   * @param Drupal\Core\Field\FieldItemListInterface $items
   *   [Explicite description].
   * @param mixed $langcode
   *   [Explicite description].
   *
   * @return array
   *   Return the markup array.
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $elements = [];

    foreach ($items as $delta => $item) {
      $rgb = [
        'r' => $item->r,
        'g' => $item->g,
        'b' => $item->b,
      ];

      $hex_color = Color::rgbToHex($rgb);
      if (empty($hex_color)) {
        $hex_color = '';
      }
      $elements[$delta] = [
        '#type' => 'html_tag',
        '#tag' => 'div',
        '#value' => $this->t('This is text'),
        '#attributes' => [
          'style' => "background-color: {$hex_color}; padding: 10px; color: #fff;",
        ],
      ];
    }
    return $elements;
  }

}
