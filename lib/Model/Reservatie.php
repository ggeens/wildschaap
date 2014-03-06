<?php
class Model_Reservatie extends Model_Base {
	public $table = 'ws_inschrijving';
	function init() {
		parent::init ();
		
		$this->hasOne ( 'Voorstelling' )->caption ( 'Voorstelling' )->required ( true );
		$this->hasOne ( 'Cursist' )->caption ( 'Cursist' )->required ( true );
		$this->addField ( 'aantal' )->type ( 'int' );
		
		$this->addField ( 'betaald' )->type ( 'boolean' )->required ( true );
	}
	function findReservatie($cursist, $voorstelling) {
		$this->addCondition ( 'ws_voorstelling_id', $voorstelling );
		$this->addCondition ( 'ws_cursist_id', $cursist );
		$this->tryLoadAny ();
		return $this;
	}
}
