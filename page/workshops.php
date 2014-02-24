<?php
class page_workshops extends Page {
	function page_index() {
		$this->api->auth->check();
		$crud = $this->add('CRUD');
		$model = $this->add('Model_Workshop', null, ['naam', 'omschrijving', 'sessies']);
		$model->addExpression('sessies')
			->set($model->refSQL('Sessie')->count())
			->caption('Sessies');
		
		$crud->setModel($model);
		
		if ($crud->grid) {
			$grid = $crud->grid;
			$grid->addPaginator(20);
			$grid->addQuickSearch(['naam']);
			$grid->addFormatter('sessies', 'expander');
			$grid->addColumn('Button', 'nieuwe_sessie');

			if ($_GET['nieuwe_sessie']) {
				$name = $crud->grid->model->load($_GET['nieuwe_sessie'])->get('naam');
 				$this->js()->univ()->frameURL('Nieuwe sessie voor '.$name,
 					$this->api->url('./nieuwsessie', array('id'=>$_GET['nieuwe_sessie'])))
 					->execute();
			}
		}
		
		$this->api->template->set('page_title', 'Workshops');
	}
	
	function page_sessies() {
		$this->api->auth->check();
		$model = $this->add('Model_Sessie');
		$model->addCondition('ws_workshop_id', $_GET['ws_workshop_id']);
		$this->api->stickyGET('ws_workshop_id');
		$model->addExpression('cursisten')
			->set($model->refSQL('Inschrijving')->count())
			->caption('Cursisten');
		$crud = $this->add('CRUD');
		$crud->setModel($model, ['datum', 'plaats', 'cursisten']);

		$g = $crud->grid;
		if ($g) {
			$g->addFormatter('cursisten', 'expander');
		}
	}
	
	function page_sessies_cursisten() {
		$this->api->auth->check();
		$model = $this->add('Model_Inschrijving');
		$model->addCondition('ws_sessie_id', $_GET['ws_sessie_id']);
		$model->addExpression('wissen')->set("'Inschrijving wissen'");
		$this->api->stickyGET('ws_sessie_id');
		$g = $this->add('View')->addStyle('#eee')->add('Grid_Extended');
		$g->setModel($model, ['ws_cursist', 'betaald', 'wissen']);
		$g->setFormatter('betaald', 'toggle');
		$g->addFormatter('wissen', 'confirm');
		
		if ($_GET['wissen']) {
			$model->load($_GET['wissen'])->delete();
			$this->js()->univ()->location($this->api->url('workshops'))->execute();
		}
	}
	
}