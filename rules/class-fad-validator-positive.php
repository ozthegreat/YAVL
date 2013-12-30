<?php

if( ! class_exists( 'Fad_Validator_Positive' ) ){

	class Fad_Validator_Positive extends Fad_Validate {

		public function positive( $s ){

			if( $s > 0 )
				return TRUE;

			else return FALSE;

		}

	}

}