<?php namespace Valitator\Rules;

class Negative extends Fad_Validate {

	public function Negative( $s )
	{
		if ( is_int( $s ) && $s < 0 )
			return TRUE;

		return FALSE;
	}

}
