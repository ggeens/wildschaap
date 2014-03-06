<?php
class Model_Base extends SQL_Model {
	function init() {
		parent::init();
		$this->add ( 'Field_Deleted', 'deleted' );
	}

	function delete($id = null) {
		if ($id)
			$this->load ( $id );
		if (! $this->loaded ())
			throw $this->exception ( 'Unable to determine which record to delete' );
		$this->set ( 'deleted', true );
		$this->saveAndUnload ();
	}
	}