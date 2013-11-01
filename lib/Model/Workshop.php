<?php
class Model_Workshop extends Model_Table
{
  public $table = 'ws_workshop';
  
  function init()
  {
    $this->addField('naam');
    $this->addField('omschrijving')->allowHTML(true);
  }
  
}
