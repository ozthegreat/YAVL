<?php

if( ! class_exists( 'Fad_Validator_Bool' ) ){

	class Fad_Validator_Bool extends Fad_Validate {

		public function Bool( $s ){

			return is_bool( $s );

		}

	}

}