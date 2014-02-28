<?php
class Model_Workshop extends SQL_Model {
	public $table = 'ws_workshop';
	public $title_field = 'naam';
	function init() {
		parent::init ();
		
		$this->addField ( 'naam' )->required ( true )->sortable ( true );
		$this->addField ( 'omschrijving' )->type ( 'text' )->allowHTML ( true );
		
		$this->hasMany ( 'Sessie' );
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
