<?php
class Model_Workshop extends Model_Base {
	public $table = 'ws_workshop';
	public $title_field = 'naam';
	function init() {
		parent::init ();
		
		$this->addField ( 'naam' )->required ( true )->sortable ( true );
		$this->addField ( 'omschrijving' )->type ( 'text' )->allowHTML ( true );
		
		$this->hasMany ( 'Sessie' );
	}
}
