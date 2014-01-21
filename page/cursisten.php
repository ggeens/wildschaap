<?php
class page_cursisten extends Page {
	function init() {
		parent::init();
		$this->api->auth->check();
		$grid = $this->add('Grid');
		$grid->addButton('Cursist toevoegen')->redirect('cursist');
		$grid->setModel('Cursist');
		$grid->addPaginator(20);
		$grid->addColumn('button', 'Aanpassen');
		
		if ($_GET['Aanpassen']) {
			$this->api->stickyGET('id');
			$url = $this->api->url('cursist', array('id'=>$_GET['Aanpassen']));
			$this->api->redirect($url);
		}

		$this->api->template->set('page_title', 'Cursisten');
	}
}