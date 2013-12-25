<?php

if( ! class_exists( 'Fad_Validator_Lessthan' ) ){

	class Fad_Validator_Lessthan extends Fad_Validate {

		public function lessthan( $s, $max ){

			if( $s < $max )
				return TRUE;

			else return FALSE;

		}

	}

}