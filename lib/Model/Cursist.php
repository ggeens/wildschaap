<?php
class Model_Cursist extends SQL_Model {
	public $table = 'ws_cursist';
	public $title_field = 'naam';
	function init() {
		parent::init ();
		
		$this->addField ( 'naam' )->required ( true )->sortable ( true );
		$this->addField ( 'email' )->sortable ( true );
		$this->addField ( 'adres' )->sortable ( true );
		$this->addField ( 'postcode' )->sortable ( true );
		$this->addField ( 'gemeente' )->sortable ( true );
		$this->addField ( 'telefoon' )->sortable ( true );
		$this->addField ( 'is_mailings' )->type ( 'boolean' )->caption ( 'Stuur email' );
		$this->addField ( 'opmerkingen' )->type ( 'text' );
		$this->add ( 'Field_Deleted', 'deleted' );
		$this->hasMany ( 'Inschrijving' );
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
