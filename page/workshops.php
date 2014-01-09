<?php
class page_workshops extends Page {
	function init() {
		parent::init();
		$this->api->auth->check();
		$this->add('CRUD')->setModel('Workshop');
	}
}