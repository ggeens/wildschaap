<?php
class Model_Inschrijving extends SQL_Model {
	public $table = 'ws_inschrijving';
	function init() {
		parent::init ();
		
		$this->hasOne ( 'Sessie' )->caption ( 'Sessie' )->required ( true );
		$this->hasOne ( 'Cursist' )->caption ( 'Cursist' )->required ( true );
		
		$this->addField ( 'betaald' )->type ( 'boolean' )->required ( true );
		$this->add ( 'Field_Deleted', 'deleted' );
	}
	function findInschrijving($cursist, $sessie) {
		$this->addCondition ( 'ws_sessie_id', $sessie );
		$this->addCondition ( 'ws_cursist_id', $cursist );
		$this->tryLoadAny ();
		return $this;
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