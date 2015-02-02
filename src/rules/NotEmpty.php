<?php namespace Valitator\Rules;

class NotEmpty extends Fad_Validate {

	public function notEmpty( $s = null )
	{
		return ! empty( $s );
	}

}
