<?php

if( ! class_exists( 'Fad_Validator_Odd' ) ){

	class Fad_Validator_Odd extends Fad_Validate {

		public function Odd( $s ){

			if( (int) $s % 2 != 0 )
				return TRUE;

			else return FALSE;

		}

	}

}