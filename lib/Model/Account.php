class Model_Account extends Model_Table 
{
  public $table = 'ws_account';
  
  function init()
  {
    parent::init();
    
    $this->addField('naam');
    $this->addField('email');
    $this->addField('passwoord');
  }
  
}
