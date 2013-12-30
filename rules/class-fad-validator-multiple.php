<?php

if( ! class_exists( 'Fad_Validator_Multiple' ) ){

	class Fad_Validator_Multiple extends Fad_Validate {

		public function multiple( $s, $multiple_of ){

			if( (int) $s % (int) $multiple_of == 0 )
				return TRUE;
			
			else return FALSE;

		}

	}

}