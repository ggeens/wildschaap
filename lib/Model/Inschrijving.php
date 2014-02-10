<?php
class Model_Inschrijving extends SQL_Model {
	public $table = 'ws_inschrijving';

	function init()
	{
		parent::init();

		$this->hasOne('Sessie')->caption('Sessie')->required(true);
		$this->hasOne('Cursist')->caption('Cursist')->required(true);

		$this->addField('betaald')->type('boolean')->required(true);
	}
}