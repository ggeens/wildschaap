<?php
class page_addaccount extends Page {
	function init() {
		parent::init ();
		$this->api->auth->check();
		$model = $this->add ( 'Model_Account' );
		
		$form = $this->add ( 'MVCForm' );
		$form->setModel ( $model );
		$form->addField ( 'password', 'paswoord' )->isMandatory ( true );
		$form->addField ( 'password', 'bevestigPaswoord' )->isMandatory ( true );
		$form->addSubmit ();
		$form->addButton('Annuleren')->redirect('account');
		
		$form->onSubmit ( function ($form) {
			if ($form->get ('paswoord') == '')
				throw $form->exception ( 'Paswoord mag niet leeg zijn' )->setField ( 'paswoord' );
			if ($form->get ( 'paswoord' ) != $form->get ( 'bevestigPaswoord' ))
				throw $form->exception ( 'Paswoorden verschillen' )->setField ( 'bevestigPaswoord' );
			$form->model->set ( 'paswoord', $form->api->auth->encryptPassword ( $form->get ( 'paswoord' ), $form->get ( 'email' ) ) );
			$form->update();
			$form->model->save();
			$form->js ()->hide ( 'slow' )->univ ()->redirect('account')->execute();
		} );
		$this->api->template->set('page_title', 'Nieuwe Gebruiker');
	}
}
