<?php
class page_stukken extends Page {
	function page_index() {
		$this->api->auth->check();
		$crud = $this->add('CRUD');
		$model = $this->add('Model_Stuk', null, array('naam', 'omschrijving', 'voorstellingen'));
		$model->addExpression('voorstellingen')
			->set($model->refSQL('Voorstelling')->count())
			->caption('Voorstellingen');
		
		$crud->setModel($model);
		
		if ($crud->grid) {
			$grid = $crud->grid;
			$grid->addPaginator(20);
			$grid->addQuickSearch(array('naam'));
			$grid->addFormatter('voorstellingen', 'expander');
			$grid->addColumn('Button', 'nieuwe_voorstelling');

			if ($_GET['nieuwe_voorstelling']) {
				$name = $crud->grid->model->load($_GET['nieuwe_voorstelling'])->get('naam');
 				$this->js()->univ()->frameURL('Nieuwe voorstelling voor '.$name,
 					$this->api->url('./nieuwvoorstelling', array('id'=>$_GET['nieuwe_voorstelling'])))
 					->execute();
			}
		}
		
		$this->api->template->set('page_title', 'Voorstellingen');
	}
	
	function page_voorstellingen() {
		$this->api->auth->check();
		$model = $this->add('Model_Voorstelling');
		$model->addCondition('ws_stuk_id', $_GET['ws_stuk_id']);
		$this->api->stickyGET('ws_stuk_id');
		$model->addExpression('reservaties')
			->set($model->refSQL('Reservatie')->sum('aantal'))
			->caption('Reservaties');
		$crud = $this->add('CRUD', array('grid_class'=>'Grid_Extended'));
		$crud->setModel($model, array('plaats', 'datum', 'uur', 'reservaties'));

		$g = $crud->grid;
		if ($g) {
			$g->addFormatter('reservaties', 'expander');
			$g->addColumn('Button', 'reservatie_toevoegen');
		}
		if ($_GET['reservatie_toevoegen']) {
			$name = $g->model->load($_GET['reservatie_toevoegen'])->get('naam');
 			$this->js()->univ()->frameURL('Nieuwe reservatie voor '.$name,
 				$this->api->url('./nieuwreservatie', array('id'=>$_GET['reservatie_toevoegen'])))
 					->execute();
		}
	}
	
	function page_voorstellingen_nieuwreservatie() {
		$this->api->auth->check();
		$model = $this->add('Model_Reservatie');
		$form = $this->add('Form')->addClass('stacked');
		$form->setModel($model);
		$form->set('ws_voorstelling_id', $_GET['id']);
		$form->addSubmit();
		if ($form->isSubmitted()) {
			$cursist = $form->get('ws_cursist_id');
			$voorstelling = $form->get('ws_voorstelling_id');
			if ($this->add('Model_Reservatie')->findReservatie($cursist, $voorstelling)->loaded()) {
				throw $form->exception('Deze persoon heeft reeds gereserveerd voor deze voorstelling')->setField('ws_cursist_id');
			}
			$form->update();
			$form->js()->univ()->location($this->api->url('../..'))->execute();
		}
	}
	
	function page_voorstellingen_reservaties() {
		$this->api->auth->check();
		$model = $this->add('Model_Reservatie');
		$model->addCondition('ws_voorstelling_id', $_GET['ws_voorstelling_id']);
		$model->addExpression('wissen')->set("'Reservatie wissen'");
		$this->api->stickyGET('ws_voorstelling_id');
		$g = $this->add('View')->addStyle('#eee')->add('Grid_Extended');
		$g->setModel($model, array('ws_cursist', 'betaald', 'aantal', 'wissen'));
		$g->setFormatter('betaald', 'toggle');
		$g->addFormatter('wissen', 'confirm');
		$g->addFormatter('aantal', 'grid/inline');
		
		if ($_GET['wissen']) {
			$model->load($_GET['wissen'])->delete();
			$this->js()->univ()->location($this->api->url('voorstellingen'))->execute();
		}
	}
	
	function page_nieuwvoorstelling() {
		$this->api->auth->check();
		$model = $this->add('Model_Voorstelling');
		$form = $this->add('Form')->addClass('stacked');
		$form->setModel($model);
		$form->set('ws_stuk_id', $_GET['id']);
		$form->addSubmit();
		if ($form->isSubmitted()) {
			$form->update();
			$form->js()->univ()->location($this->api->url('..'))->execute();
		}
	}
}