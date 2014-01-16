<?php
class page_account extends Page {
	private $id;
	
	function init() {
		parent::init();
		$this->api->auth->check();
		$CRUD = $this->add('CRUD', array('allow_add'=>false));
		$model = $CRUD->setModel('Account');
		if ($CRUD->grid)
			$CRUD->grid->addButton('Nieuwe Gebruiker')->redirect('addaccount');
		$f = $CRUD->addFrame('zet paswoord');
		if ($f != null) {
			$this->id = $CRUD->id;
			$model->load($this->id);
			$f->add('P')->set('Zet paswoord voor '.$model->get('naam'));
			$form = $f->add('Form');
			$form->addField('password', 'paswoord');
			$form->addField('password', 'herhaalpaswoord')->setCaption('Herhaal Paswoord');
 			$form->addSubmit ( 'Wijzig' );
 			$form->onSubmit ( array($this, 'submitted') );
		}
		$this->api->template->set('page_title', 'Gebruikers');
	}
	
	function submitted($form) {
		if ($form->get ( 'paswoord' ) == '')
			throw $form->exception ( 'Paswoord mag niet leeg zijn' )->setField ( 'paswoord' );
		if ($form->get ( 'herhaalpaswoord' ) == '')
			throw $form->exception ( 'Herhaal Paswoord mag niet leeg zijn' )->setField ( 'herhaalpaswoord' );
		if ($form->get ( 'paswoord' ) != $form->get ( 'herhaalpaswoord' ))
			throw $form->exception ( 'Paswoorden verschillen' )->setField ( 'herhaalpaswoord' );

		$account = $this->add('Model_Account');
		$account->load($this->id);
		$account->set ( 'paswoord', $form->api->auth->encryptPassword ( $form->get ( 'paswoord' ), $account->get ( 'email' ) ) );
		$account->save();

		$form->js ( null, $this->js ()->trigger ( 'reload' ) )->univ ()->closeDialog ()->execute();
			
	}
}