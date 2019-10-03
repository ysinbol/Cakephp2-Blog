<?php
App::uses('AppModel', 'Model');
/**
 * Prefecture Model
 *
 */
class Region extends AppModel
{

  /**
   * Use table
   *
   * @var mixed False or table name
   */
  public $useTable = 'region';

  /**
   * Display field
   *
   * @var string
   */
  public $displayField = 'name';
}
