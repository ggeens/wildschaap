<?php
class Model_Voorstelling extends Model_Base {
	public $table = 'ws_voorstelling';
	public $title_field = 'title';
	function init() {
		parent::init();

		$this->addField ( 'plaats' )->required ( true )->sortable ( true )->sortable ( true );
		$this->addField ( 'datum' )->type ( 'date' )->required ( true )->sortable ( true );
		$this->addField ( 'uur' )->type ( 'daytime' )->required ( true );
		$this->addField ( 'prijs' )->type ( 'money' )->required ( true );
		$this->addField ( 'capaciteit' )->required ( true )->type ( 'int' )->caption ( 'Max. plaatsen' );
		
		$this->hasOne ( 'Stuk' )->caption ( 'Stuk' );
		$this->hasMany ( 'Reservatie' );
		
		$this->addExpression ( 'title' )->set ( 'null' );
		
		$this->addHook ( 'afterLoad', function ($o) {
			$n = $o->get ( 'ws_stuk' );
			$d = $o->get ( 'datum' );
			$t = $o->get ( 'uur' );
			$o->set ( 'title', $n . ' (' . $d. ' ' . $t . ')' );
		} );
	}
}