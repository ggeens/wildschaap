<?php
class Model_Inschrijving extends SQL_Model {
	public $table = 'ws_inschrijving';

	function init()
	{
		parent::init();

		$this->addField('betaald')->type('boolean')->required(true);

		$this->hasOne('Sessie')->caption('Sessie');
		$this->hasOne('Cursist')->caption('Cursist');
	}
}