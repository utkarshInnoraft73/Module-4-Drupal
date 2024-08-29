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
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $elements = [];

    foreach ($items as $delta => $item) {
      $rgb = [
        'r' => $item->r ?? 0,
        'g' => $item->g ?? 0,
        'b' => $item->b ?? 0,
      ];

      $hex_color = Color::rgbToHex($rgb);
      if (empty($hex_color) || $hex_color === '#00000') {
        $hex_color = '#000000';
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
