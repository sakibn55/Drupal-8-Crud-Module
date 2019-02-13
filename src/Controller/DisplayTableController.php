<?php
namespace Drupal\mymodule\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
/**
 * Class DisplayTableController.
 *
 * @package Drupal\mymodule\Controller
 */
class DisplayTableController extends ControllerBase {
  /**
   * Display.
   *
   * @return string
   *   Return Table with Data.
   */
  public function display() {
    //create table header
    $header_table = array(
      'id'=>    t('SrNo'),
      'name' => t('Name'),
      'mobilenumber' => t('MobileNumber'),
      'email'=>t('Email'),
      'age' => t('Age'),
      'gender' => t('Gender'),
      'website' => t('Web Link'),
      'opt' => t('operations'),
      'opt1' => t('operations'),
    );
//select records from table
    $query = \Drupal::database()->select('mydata', 'm');
    $query->fields('m', ['id','name','mobilenumber','email','age','gender','website']);
    $results = $query->execute()->fetchAll();
    $rows=array();
    foreach($results as $data){
      $delete = Url::fromUserInput('/mymodule/'.$data->id.'/delete');
      $edit   = Url::fromUserInput('/mymodule/myform?num='.$data->id);
      //print the data from table
      $rows[] = array(
        'id' =>$data->id,
        'name' => $data->name,
        'mobilenumber' => $data->mobilenumber,
        'email' => $data->email,
        'age' => $data->age,
        'gender' => $data->gender,
        'website' => $data->website,
        \Drupal::l('Delete', $delete),
        \Drupal::l('Edit', $edit),
      );
    }
    //display data in site
    $form['table'] = [
        '#type' => 'table',
        '#header' => $header_table,
        '#rows' => $rows,
        '#empty' => t('No users found'),
        ];
        return $form;
  }
}