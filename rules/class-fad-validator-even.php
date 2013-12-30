<?php

if( ! class_exists( 'Fad_Validator_Even' ) ){

	class Fad_Validator_Even extends Fad_Validate {

		public function even( $s ){

			if( (int) $s % 2 == 0 )
				return TRUE;

			else return FALSE;

		}

	}

}