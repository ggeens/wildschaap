<?php
class Model_Account extends Model_Table 
{
  public $table = 'ws_account';
  
  function init()
  {
    parent::init();
    
    $this->addField('naam')->required(true);
    $this->addField('email')->required(true);
    $this->addField('paswoord')->type('password')->required(true);
  }
  
}
