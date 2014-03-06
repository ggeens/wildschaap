<?php
class WildschaapAuth extends BasicAuth {
    /** Initialize our auth. Set model and password encryption */
    function init(){
        parent::init();
        $this->setModel('Model_Account');
        $this->getModel()->getField('paswoord')->system(true);

        $this->usePasswordEncryption('sha256/salt');
    }

    /** Do not show form, simply redirect to index page, if not authorized */
    function check(){
        if(!$this->isLoggedIn()){
            $this->api->redirect('login');
        }
    }

    /** Password validation routine, now using the model. */
    function verifyCredentials($email,$password){
        $model = $this->getModel()->tryLoadBy('email',$email);
        if(!$model->isInstanceLoaded())return false;
        if($password == $model->get('paswoord')){
            $this->addInfo($model->get());
            unset($this->info['password']);
            return true;
        }else return false;

    }
    
    function isAdmin() {
    	return $this->get('admin');
    }
}
