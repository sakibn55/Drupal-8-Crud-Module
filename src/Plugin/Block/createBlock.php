<?php

namespace Drupal\mymodule\Plugin\Block;
use Drupal\Core\Block\BlockBase;
/**
 * Provides a 'Add MyModule data' Block.
 *
 * @Block(
 *   id = "Add_MyModule_data",
 *   admin_label = @Translation("Add MyModule data"),
 *   category = @Translation("Add MyModule data"),
 * )
 */
class CreateBlock extends BlockBase {
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\mymodule\Form\CreateDataForm');
    return $form;
  }

}
