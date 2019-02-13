<?php
namespace Drupal\mymodule\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
/**
 * Class CreateDataForm.
 *
 * @package Drupal\mymodule\Form
 */
class CreateDataForm extends FormBase {
  /*
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'mymodule_create_form';
  }
  public function buildForm(array $form, FormStateInterface $form_state) {
    $conn = Database::getConnection();
    $record = array();
    if (isset($_GET['id'])) {
        $query = $conn->select('mydata', 'm')
            ->condition('id', $_GET['id'])
            ->fields('m');
        $record = $query->execute()->fetchAssoc();
    }
    $form['full_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Full Name:'),
      '#required' => TRUE,
      //'#default_values' => array(array('id')),
      '#default_value' => (isset($record['name']) && $_GET['num']) ? $record['name']:'',
      );
    $form['mobile_number'] = array(
      '#type' => 'textfield',
      '#title' => t('Mobile Number:'),
      '#default_value' => (isset($record['mobilenumber']) && $_GET['num']) ? $record['mobilenumber']:'',
      );
    $form['mail'] = array(
      '#type' => 'email',
      '#title' => t('Email:'),
      '#required' => TRUE,
      '#default_value' => (isset($record['email']) && $_GET['num']) ? $record['email']:'',
      );
    $form['age'] = array (
      '#type' => 'textfield',
      '#title' => t('AGE'),
      '#required' => TRUE,
      '#default_value' => (isset($record['age']) && $_GET['num']) ? $record['age']:'',
      );
    $form['gender'] = array (
      '#type' => 'select',
      '#title' => ('Gender'),
      '#options' => array(
        ''=>t('--Select--'),
        'Female' => t('Female'),
        'Male' => t('Male'),
        ),
      '#default_value' => (isset($record['gender']) && $_GET['num']) ? $record['gender']:'',
      );
  $form['web_site'] = array (
      '#type' => 'textfield',
      '#title' => t('Web Link'),
      '#default_value' => (isset($record['website']) && $_GET['num']) ? $record['website']:'',
      );
    $form['submit'] = [
        '#type' => 'submit',
        '#value' => 'Save',
    ];
    return $form;
  }
  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (!intval($form_state->getValue('age'))) {
        $form_state->setErrorByName('age', $this->t('Age needs to be a number'));
        }
    if (strlen($form_state->getValue('mobile_number')) < 10 ) {
        $form_state->setErrorByName('mobile_number', $this->t('your mobile number must in 10 digits'));
      }
    parent::validateForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $field=$form_state->getValues();
    $name=$field['full_name'];
    //echo "$name";
    $number=$field['mobile_number'];
    $email=$field['mail'];
    $age=$field['age'];
    $gender=$field['gender'];
    $website=$field['web_site'];
    if (isset($_GET['num'])) {
      $field  = array(
          'name'   => $name,
          'mobilenumber' =>  $number,
          'email' =>  $email,
          'age' => $age,
          'gender' => $gender,
          'website' => $website,
      );
      $query = \Drupal::database();
      $query->update('mydata')
          ->fields($field)
          ->condition('id', $_GET['num'])
          ->execute();
      drupal_set_message("succesfully updated");
      $form_state->setRedirect('mydata.display_table_controller_display');
    }
    else
    {
      $field  = array(
          'name'   =>  $name,
          'mobilenumber' =>  $number,
          'email' =>  $email,
          'age' => $age,
          'gender' => $gender,
          'website' => $website,
      );
      $query = \Drupal::database();
      $query ->insert('mydata')
              ->fields($field)
              ->execute();
      drupal_set_message("succesfully saved");
      $form_state->setRedirect('mydata.display_table_controller_display');
    }
  }
}