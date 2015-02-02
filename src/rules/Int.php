<?php namespace Valitator\Rules;

class Int extends Fad_Validate {

	public function int( $i )
	{
		return ( ! filter_var( $i, FILTER_VALIDATE_INT ) ? FALSE : TRUE );
	}

}
