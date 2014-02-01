<?php
class page_cursisten extends Page {
	function page_index() {
		$this->api->auth->check();
		$model = $this->add('Model_Cursist');
		$model->addExpression('inschrijvingen')
			->set($model->refSQL('Inschrijving')->count())
			->caption('Sessies');
		$crud = $this->add('CRUD');
		$model = $crud->setModel($model, null, ['naam', 'email', 'inschrijvingen']);
		if ($crud->grid) {
			$grid = $crud->grid;
			$grid->addPaginator(20);
			$grid->addQuickSearch(['naam', 'email']);
			$grid->addFormatter('inschrijvingen', 'expander');
			$grid->addColumn('Button', 'inschrijven');
			
			if ($_GET['inschrijven']) {
				$name = $crud->grid->model->load($_GET['inschrijven'])->get('naam');
 				$this->js()->univ()->frameURL('Nieuwe inschrijving voor '.$name,
 					$this->api->url('./inschrijven', array('id'=>$_GET['inschrijven'])))
 					->execute();
			}
		}

		$this->api->template->set('page_title', 'Cursisten');
	}
	
	function page_inschrijvingen() {
		$this->api->auth->check();
		$model = $this->add('Model_Sessie');
		$inschrijving = $model->join('ws_inschrijving.ws_sessie_id');
		$inschrijving->addField('ws_cursist_id');
		$inschrijving->addField('ws_inschrijving_id', 'id')->system(true);
		$inschrijving->addField('betaald')->type('boolean')->caption('Betaald');
		
		$model->addCondition('ws_cursist_id', $_GET['ws_cursist_id']);
		$this->api->stickyGET('ws_cursist_id');
		
		$g = $this->add('View')->addStyle('#eee')->add('Grid');
		$g->setModel($model);
	}
	
	function page_inschrijven() {
		$this->api->auth->check();
		$model = $this->add('Model_Inschrijving');
		$form = $this->add('Form')->addClass('stacked');
		$form->setModel($model);
		$form->set('ws_cursist_id', $_GET['id']);
		$form->getField('Cursist')->setReadOnly(true);
		$form->addSubmit();
		if ($form->isSubmitted()) {
			$form->update();
			$form->js()->univ()->location($this->api->url('..'))->execute();
		}
	}
}