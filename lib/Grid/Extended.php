<?php
class Grid_Extended extends Grid
{
	function init_toggle($field) {
        $this->init_button($field);
	}
	
	function format_toggle($field) {
		$url = clone $this->_url[$field];
		$class = $this->columns[$field]['button_class'].' button_'.$field;
		$icon = isset($this->columns[$field]['icon'])
			? $this->columns[$field]['icon']
			: '';
		if ($this->current_row[$field] && $this->current_row[$field] !== 'N') {
			$value = 'Ja';
		} else {
			$value = 'Nee';
		}

		if ($id = @$_GET[$this->name.'_'.$field]) {
		
			// delete record
			$this->_performToggle($field, $id);
		
			// show message
			$this->js()->univ()
				->getjQuery()
				->reload()
				->execute();
		}

		$this->current_row_html[$field] =
			'<div align="center"><button type="button" class="'.$class.'" '.
			'onclick="$(this).univ().ajaxec(\'' .
			$url->set(array(
				$field => $this->current_id,
				$this->name.'_'.$field => $this->current_id
			)) . '\')"'.
			'>'.
			$icon.
			$value.
			'</button></div>';
	}
	
	function _performToggle($field, $id) {
		$m = $this->model;
		$m->load($id);
		$value = $m->get ( $field );
		$m->set ( $field, $value == 0 ? 1 : 0 );
		$m->save ();
	}
}