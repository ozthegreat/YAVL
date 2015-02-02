<?php namespace Valitator\Rules;

class Even extends Fad_Validate {

	public function even( $s )
	{
		if ( is_int($s) && $s % 2 == 0 )
			return TRUE;

		return FALSE;
	}

}
