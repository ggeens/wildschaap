<?php
class page_cursisten extends Page {
	function page_index() {
		$this->api->auth->check();
		$model = $this->add('Model_Cursist');
		$model->addExpression('inschrijvingen')
			->set($model->refSQL('Inschrijving')->count())
			->caption('Sessies');
		$crud = $this->add('CRUD');
		$model = $crud->setModel($model, null, array('naam', 'email', 'inschrijvingen'));
		if ($crud->grid) {
			$grid = $crud->grid;
			$grid->addPaginator(20);
			$grid->addQuickSearch(array('naam', 'email'));
			$grid->addFormatter('inschrijvingen', 'expander');
			$grid->addColumn('Button', 'inschrijven');
			
			if ($_GET['inschrijven']) {
				$name = $crud->grid->model->load($_GET['inschrijven'])->get('naam');
 				$this->js()->univ()->frameURL('Nieuwe inschrijving voor '.$name,
 					$this->api->url('./nieuw', array('id'=>$_GET['inschrijven'])))
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
		
		$g = $this->add('View')->addStyle('background-color: #eee')->add('Grid_Extended');
		$g->setModel($model, array('ws_workshop', 'datum', 'plaats', 'betaald'));
		$g->setFormatter('betaald', 'toggle');
		$g->addColumn('Button', 'wissen');
		$g->addFormatter('wissen', 'confirm');
		
		if ($_GET['wissen']) {
			$model = $this->add('Model_Inschrijving');
			$cursist = $_GET['ws_cursist_id'];
			$sessie = $_GET['wissen'];
			$model->findInschrijving($cursist, $sessie)->delete();
			$this->js()->univ()->location($this->api->url('cursisten'))->execute();
		}
	}
	
	function page_nieuw() {
		$this->api->auth->check();
		$model = $this->add('Model_Inschrijving');
		$form = $this->add('Form')->addClass('stacked');
		$form->setModel($model);
		$form->set('ws_cursist_id', $_GET['id']);
		$form->addSubmit();
		if ($form->isSubmitted()) {
			$cursist = $form->get('ws_cursist_id');
			$sessie = $form->get('ws_sessie_id');
			if ($this->add('Model_Inschrijving')->findInschrijving($cursist, $sessie)->loaded()) {
				throw $form->exception('Deze cursist is reeds ingeschreven voor deze sessie')->setField('ws_sessie_id');
			}
			$form->update();
			$form->js()->univ()->location($this->api->url('..'))->execute();
		}
	}
}