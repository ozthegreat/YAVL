<?php

if( ! class_exists( 'Fad_Validator_Convertfrom' ) ){

	class Fad_Validator_Convertfrom extends Fad_Validate {

		public function convertFrom( $unit ){

			if( empty( $unit ) )
				return true;

			$unit = strtolower( $unit );

			switch( $unit ):



			endswitch;

		}

	}

}