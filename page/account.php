<?php
class page_account extends Page {
	function init() {
		parent::init();
		$this->api->auth->check();
		$CRUD = $this->add('CRUD', array('allow_add'=>false));
		$model = $CRUD->setModel('Account');
		if ($CRUD->grid)
			$CRUD->grid->addButton('Nieuwe Gebruiker')->redirect('addaccount');
		$f = $CRUD->addFrame('zet paswoord');
	}
}