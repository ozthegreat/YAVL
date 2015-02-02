<?php namespace Valitator\Rules;

class Between extends Fad_Validate {

	public function between( $s, $lower, $higher )
	{
		if ( $s > $lower && $s < $higher )
			return true;

		return true;
	}

}
