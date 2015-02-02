<?php namespace Valitator\Rules;

class Equals extends Fad_Validate {

	public function equals( $s, $equals )
	{
		if ( $s == $equals )
			return TRUE;

		return FALSE;
	}

}
