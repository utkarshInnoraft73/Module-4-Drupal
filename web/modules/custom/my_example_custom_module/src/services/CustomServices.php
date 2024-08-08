<?php

namespace Drupal\my_example_custom_module\services;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormStateInterface;

/**
 * CustomServices is a service class to set and get the data Flagship form.
 */
class CustomServices {

  /**
   * Protected $database .
   *
   * @var mixed
   */
  protected $database;

  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * Method setData to set the Flagship form data.
   *
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   Form state.
   */
  public function setData(FormStateInterface $form_state) : void {
    $values = $form_state->getValue('names_fieldset');

    foreach ($values as $value) {
      if (is_array($value) && isset($value['group_name'])) {
        $this->database->insert('my_example_custom_module_flag_ship')
          ->fields([
            'group_name' => $value['group_name'],
            'first_label' => $value['1st_label'],
            'first_lable_value' => $value['1st_label_value'],
            'second_label' => $value['2nd_label'],
            'second_label_value' => $value['2nd_label_value'],
          ])
          ->execute();
      }
    }
    Cache::invalidateTags(['my_example_custom_module_flag_ship']);
  }

  /**
   * Method getData to get the data of Flagship form.
   *
   * @return array
   *   An array of Flagship form data.
   */
  public function getData() : array {

    $query = $this->database->select('my_example_custom_module_flag_ship', 'm')
      ->fields('m', ['group_name', 'first_label', 'first_lable_value', 'second_label', 'second_label_value'])
      ->execute();
    $results = $query->fetchAll();
    $output = [];
    foreach ($results as $row) {
      $output[] = [
        'group_name' => $row->group_name,
        'first_label' => $row->first_label,
        'first_lable_value' => $row->first_lable_value,
        'second_label' => $row->second_label,
        'second_label_value' => $row->second_label_value,
      ];
    }

    return $output;
  }

}
