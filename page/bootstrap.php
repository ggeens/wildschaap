<?php
class page_bootstrap extends Page
{
  function init()
  {
    parent::init();
    $model = $this->add('Model_Account');

    if ($model->count()->getOne() > 0) {
      throw $this->exception('Init reeds gebeurd');
    }
    
    $form = $this->add('MVCForm');
    $form->setModel($model);
    $form->addField('password', 'bevestigPaswoord')->setMandatory(true);
    $form->addSubmit();

    $form->onSubmit(function($form)
		    {
		      if ($form->get('paswoord') != $form->get('bevestigPaswoord'))
			throw $form->exception('Paswoorden verschillen')->setField('bevestigPaswoord');
		      $form->set('paswoord', $form->api->auth->encryptPassword($form->get('paswoord'), $form->get('email')));
		      $form->update();
		      $form->js()->hide('slow')->univ()->successMessage('Gebruiker bewaard')->execute();
		    });
  }
}
