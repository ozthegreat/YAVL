<?php

if( ! class_exists( 'Fad_Validator_Negative' ) ){

	class Fad_Validator_Negative extends Fad_Validate {

		public function Negative( $s ){

			if( $s < 0 )
				return TRUE;

			else return FALSE;

		}

	}

}