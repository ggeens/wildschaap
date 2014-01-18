<?php
class Model_Translation extends \SQL_Model {
	public $table="ws_translation";
	function init(){
		parent::init();

		$this->addField('key')->system(true)->visible(true)->editable(true)->readonly(true)->sortable(true);
		$this->addField('tr_nl')->sortable(true);
	}
}
