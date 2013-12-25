<?php

if( ! class_exists( 'Fad_Validator_Greaterthan' ) ){

	class Fad_Validator_Greaterthan extends Fad_Validate {

		public function greaterthan( $s, $min ){

			if( $s > $min )
				return TRUE;

			else return FALSE;

		}

	}

}