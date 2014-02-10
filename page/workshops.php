<?php
class page_workshops extends Page {
	function init() {
		parent::init();
		$this->api->auth->check();
		$grid = $this->add('CRUD');
		$grid->setModel('Workshop');
		
		$grid->addRef('Sessie', ['label' => 'Sessies', 'grid_fields'=> ['datum', 'plaats', 'prijs']]);
		$grid->grid->addPaginator();
		$this->api->template->set('page_title', 'Workshops');
	}
}