<?php namespace Valitator\Rules;

class Bool extends Fad_Validate {

	public function Bool( $s )
	{
		return is_bool( $s );
	}

}
