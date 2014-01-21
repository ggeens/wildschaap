<?php
class page_cursist extends Page {
	function init() {
		parent::init();
		$this->api->auth->check();
		$model = $this->add('Model_Cursist');
		if ($_GET['id']) {
			$model->load($_GET['id']);
			$this->api->stickyGET('id');
		}
		$form = $this->add ( 'MVCForm' );
		$form->setModel ( $model );
		$form->addSubmit ();
		$form->addButton('Annuleren')->redirect('cursisten');

		$form->onSubmit ( function ($form) {
			$form->update();
			$this->api->stickyForget('id');
			$form->js ()->hide ( 'slow' )->univ ()->redirect('cursisten')->execute();
		} );
		
		$this->api->template->set('page_title', 'Cursist');
	}
}