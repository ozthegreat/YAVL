<?php namespace Valitator\Rules;

class LessThan extends Fad_Validate {

	public function lessthan( $s, $max )
	{
		if ( $s < $max )
			return TRUE;

		return FALSE;
	}

}
