<?php
class AccountForm extends Form {
	public function init() {
		parent::init();
		$this->onSubmit ( function ($form) {
			if ($form->get ('paswoord') == '')
				throw $form->exception ( 'Paswoord mag niet leeg zijn' )->setField ( 'paswoord' );
			if ($form->get ( 'paswoord' ) != $form->get ( 'bevestig Paswoord' ))
				throw $form->exception ( 'Paswoorden verschillen' )->setField ( 'bevestigPaswoord' );
			$form->model->set ( 'paswoord', $form->api->auth->encryptPassword ( $form->get ( 'paswoord' ), $form->get ( 'email' ) ) );
			$form->update ();
			$form->js ()->hide ( 'slow' )->univ ()->successMessage ( 'Gebruiker bewaard' )->execute ();
		} );
	}
	
	public function setModel($model, $actual_fields = undefined) {
		$m = parent::setModel($model, $actual_fields);
		$this->addField ( 'password', 'paswoord' )->setMandatory ( true );
		$this->addField ( 'password', 'bevestig Paswoord' )->setMandatory ( true );
		return $m;
	}
}