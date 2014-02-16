<?php
class Model_Account_Admin extends Model_Account {
	function init()
	{
		parent::init();
		$this->addCondition('admin', 'Y');
		$this->getField('admin')->system(true);
	}
}
