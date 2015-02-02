<?php namespace Valitator\Rules;

class Multiple extends Fad_Validate {

	public function multiple( $s, $multiple_of )
	{
		if ( is_int( $s ) && $s % (int) $multiple_of == 0 )
			return TRUE;

		return FALSE;
	}

}
