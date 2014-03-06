<?php
class Model_Stuk extends Model_Base {
	public $table = 'ws_stuk';
	public $title_field = 'naam';
	function init() {
		parent::init ();
		
		$this->addField ( 'naam' )->required ( true )->sortable ( true );
		$this->addField ( 'omschrijving' )->type ( 'text' )->allowHTML ( true );
		
		$this->hasMany ( 'Voorstelling' );
	}
}