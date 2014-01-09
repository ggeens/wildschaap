<?php
class Model_Workshop extends SQL_Model
{
  public $table = 'ws_workshop';
  
  function init()
  {
  	parent::init();
  	
    $this->addField('naam');
    $this->addField('omschrijving')->type('text')->allowHTML(true);
  }
  
}
