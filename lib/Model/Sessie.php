<?php
class Model_Sessie extends Model_Base {
	public $table = 'ws_sessie';
	public $title_field = 'title';
	function init() {
		parent::init ();
		
		$this->addField ( 'plaats' )->required ( true )->sortable ( true )->sortable ( true );
		$this->addField ( 'datum' )->type ( 'date' )->required ( true )->sortable ( true )->caption ( 'Begindatum' );
		$this->addField ( 'prijs' )->type ( 'money' );
		$this->addField ( 'capaciteit' )->required ( true )->type ( 'int' )->caption ( 'Max. deelnemers' );
		
		$this->hasOne ( 'Workshop' )->caption ( 'Workshop' );
		$this->hasMany ( 'Inschrijving' );
		
		$this->addExpression ( 'title' )->set ( 'null' );
		
		$this->addHook ( 'afterLoad', function ($o) {
			$n = $o->get ( 'ws_workshop' );
			$d = $o->get ( 'datum' );
			$o->set ( 'title', $n . ' (' . $d . ')' );
		} );
	}
}