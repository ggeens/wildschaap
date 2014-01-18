<?php
class Model_Sessie extends SQL_Model {
	public $table = 'ws_sessie';
	
	function init()
	{
		parent::init();
		
		$this->addField('datum')->type('date')->required(true)->sortable(true);
		$this->addField('plaats')->required(true)->sortable(true)->sortable(true);
		$this->addField('prijs')->type('money');
		
		$this->hasOne('Workshop')->caption('Workshop');
	}
}