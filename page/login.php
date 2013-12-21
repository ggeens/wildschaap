<?php
class page_login extends Page {
	function init() {
		parent::init ();
		$page = $this;
		
		$form = $this->add ( 'Form', null, 'LoginForm' );
		$form->setFormClass ( 'vertical' );
		$form->addField ( 'line', 'login' );
		$form->addfield ( 'password', 'password' );
		$form->addSubmit ( 'Login' );
		
		if ($form->isSubmitted ()) {
			
			// Short-cuts
			$auth = $this->api->auth;
			$l = $form->get ( 'login' );
			$p = $form->get ( 'password' );
			
			// Manually encrypt password
			$enc_p = $auth->encryptPassword ( $p, $l );
			
			// Manually verify login
			if ($auth->verifyCredentials ( $l, $enc_p )) {
				
				// Manually log-in
				$auth->login ( $l );
				$form->js ()->univ ()->redirect ( '/' )->execute ();
			}
			$form->getElement ( 'password' )->displayFieldError ( 'Incorrect login' );
		}
	}
	function defaultTemplate() {
		return array (
				'page/login' 
		);
	}
}
