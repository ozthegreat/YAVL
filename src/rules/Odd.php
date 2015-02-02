<?php namespace Valitator\Rules;

class Fad_Validator_Odd extends Fad_Validate {

	public function Odd( $s )
	{
		if ( is_int( $s ) && $s % 2 != 0 )
			return TRUE;

		return FALSE;
	}

}
