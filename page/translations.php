<?php
class page_translations extends \Page {
	function init(){
		parent::init();

		$this->api->auth->check();
		$this->add('CRUD')->setModel('Translation');
	}

}