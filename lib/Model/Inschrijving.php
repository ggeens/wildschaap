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
	
	function findInschrijving($cursist, $sessie) {
		$this->addCondition('ws_sessie_id', $sessie);
		$this->addCondition('ws_cursist_id', $cursist);
		$this->tryLoadAny();
		return $this;
	}
}