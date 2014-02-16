<?php
class Model_Account_Noadmin extends Model_Account {
	function init()
	{
		parent::init();
		$this->addCondition('admin', '<>', true);
		$this->getField('admin')->system(true);
	}
}
