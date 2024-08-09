<?php

namespace Drupal\my_example_custom_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\my_example_custom_module\services\CustomServices;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a my_example_custom_module form.
 *
 * This class build, submit a form for flagship programme on the webpage.
 */
class FlagShipForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'my_example_custom_module_flag_ship';
  }

  /**
   * Protected loaddata.
   *
   * @var mixed
   */
  protected $loaddata;

  public function __construct(CustomServices $loaddata) {
    $this->loaddata = $loaddata;
  }

  /**
   * Method create.
   *
   * @param CSymfony\Component\DependencyInjection\ContainerInterface $container
   *   [Explicite description].
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('my_example_custom_module.db_operations')
    );
  }

  /**
   * Method buildForm to build the form.
   *
   * This form is a AJAX form that has a button for add form. When the user
   * Clicks the button the same form will be added one next time again. There is
   * Also a remove button that remove the forms.
   *
   * @param array $form
   *   The form elements.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   *
   * @return array
   *   Return the form 'names_fieldset'.
   */
  public function buildForm(array $form, FormStateInterface $form_state) : array {

    $i = 0;
    $name_field = $form_state->get('num_names');
    $form['#tree'] = TRUE;
    $form['names_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Add/Remove new groups.'),
      '#prefix' => '<div id="names-fieldset-wrapper">',
      '#suffix' => '</div>',
    ];

    if (empty($name_field)) {
      $name_field = $form_state->set('num_names', 1);
    }
    for ($i = 0; $i < $form_state->get('num_names'); $i++) {
      $form['names_fieldset'][$i]['group_heading'] = [
        '#type' => 'markup',
        '#markup' => "<h2>" . $this->t('Group @i', ['@i' => $i + 1]) . "</h2>",
        '#prefix' => '<div>',
        '#suffix' => '</div>',
      ];
      $form['names_fieldset'][$i]['group_name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Group name'),
        '#required' => TRUE,
      ];
      $form['names_fieldset'][$i]['1st_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('1st Label name'),
        '#required' => TRUE,
      ];
      $form['names_fieldset'][$i]['1st_label_value'] = [
        '#type' => 'textfield',
        '#title' => $this->t('1st Label value'),
        '#required' => TRUE,
      ];
      $form['names_fieldset'][$i]['2nd_label'] = [
        '#type' => 'textfield',
        '#title' => $this->t('2nd Label name'),
        '#required' => TRUE,
      ];
      $form['names_fieldset'][$i]['2nd_label_value'] = [
        '#type' => 'textfield',
        '#title' => $this->t('2nd Label value'),
        '#required' => TRUE,
      ];
    }

    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['names_fieldset']['actions']['add_name'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add one more'),
      '#submit' => ['::addOne'],
      '#ajax' => [
        'callback' => '::addmoreCallback',
        'wrapper' => 'names-fieldset-wrapper',
      ],
    ];
    if ($form_state->get('num_names') > 1) {
      $form['names_fieldset']['actions']['remove_name'] = [
        '#type' => 'submit',
        '#value' => $this->t('Remove one'),
        '#submit' => ['::removeCallback'],
        '#ajax' => [
          'callback' => '::addmoreCallback',
          'wrapper' => 'names-fieldset-wrapper',
        ],
      ];
    }
    $form_state->setCached(FALSE);
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * Method addOne to add one form.
   *
   * @param array $form
   *   The form elements.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   */
  public function addOne(array &$form, FormStateInterface $form_state) : void {
    $name_field = $form_state->get('num_names');
    $add_button = $name_field + 1;
    $form_state->set('num_names', $add_button);
    $form_state->setRebuild();
  }

  /**
   * Method addmoreCallback.
   *
   * @param array $form
   *   The form elements.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   Form state.
   *
   * @return array
   *   Return the forms.
   */
  public function addmoreCallback(array &$form, FormStateInterface $form_state) : array {
    $form_state->get('num_names');
    return $form['names_fieldset'];
  }

  /**
   * Method removeCallback to remove callback.
   *
   * @param array $form
   *   Form elements.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   Form state.
   */
  public function removeCallback(array &$form, FormStateInterface $form_state) : void {
    $name_field = $form_state->get('num_names');
    if ($name_field > 1) {
      $remove_button = $name_field - 1;
      $form_state->set('num_names', $remove_button);
    }
    $form_state->setRebuild();
  }

  /**
   * Method submitForm to submit the form.
   *
   * @param array $form
   *   The form elements.
   * @param Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->loaddata->setData($form_state);
    $this->messenger()->addStatus($this->t('The message has been sent.'), 'status');
    $form_state->setRedirect('<front>');

  }

}
