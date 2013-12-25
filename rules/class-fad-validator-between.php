<?php

if( ! class_exists( 'Fad_Validator_Between' ) ){

	class Fad_Validator_Between extends Fad_Validate {

		public function between( $s, $lower, $higher ){

			if( $s > $lower && $s < $higher )
				return TRUE;

			else return FALSE;

		}

	}

}