<?php
class Model_Account extends SQL_Model 
{
  public $table = 'ws_account';
  
  function init()
  {
    parent::init();
    
    $this->addField('naam')->required(true)->sortable(true);
    $this->addField('email')->required(true)->sortable(true);
    $this->addField('paswoord')->type('password')->required(true)->system(true);
  }
  
}
