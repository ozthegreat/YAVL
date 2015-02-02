<?php namespace Valitator\Rules;

class Fad_Validator_Positive extends Fad_Validate {

	public function positive( $s )
	{
		if ( is_int( $s ) && $s > 0 )
			return TRUE;

		return FALSE;
	}

}
