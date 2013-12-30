<?php

if( ! class_exists( 'Fad_Validator_Equals' ) ){

	class Fad_Validator_Equals extends Fad_Validate {

		public function equals( $s, $equals ){

			if( $s == $equals )
				return TRUE;

			else return FALSE;

		}

	}

}