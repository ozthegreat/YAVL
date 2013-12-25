<?php

/**
 * TODO:
 * 
 * Define Error messages at a class level. Allow params to be passed
 * Store loaded glasses globally so only loading once.
 * Change returned options (boolean).
 * Break on first error.
 * How it stores error, show values passed for each individual functions
 * 
 */

require 'class-fad-validate.php';

$query_chain = Fad_Validate::initialize()->int()->between( 12, 20 )->lessThan( 17 )->greaterThan( 13 );

$query_chain->validate( 12 );

echo $query_chain->get_html_errors();
echo '<br /><br />';
print_r( $query_chain->get_actions() );
echo '<br /><br />';
print_r( $query_chain->get_errors() );

/*

class Chain {

  public static $instance;
  protected $_str  = '';
  protected $_part = 0;
  public $results = array();

  public static function start(){

	  self::$instance = new self();

	  return self::$instance;

  }
  
  public function __toString() {
    return implode(' ', $this->_str);
  }

  function __call( $method, $args ){
	$this->_str[$this->_part] = $method;
    $this->_part++;
    return $this;
  }

  public function wrap ($str) {
    $part = $this->_part - 1;
    $this->_str[$part] = "({$str})";
    return $str;
  }
  
  public function run(){

	$class =  new Test();
	for( $i = 0; $i < $this->_part; $i ++ ){

		$this->results[] = call_user_func_array( array( $class, $this->_str[ $i ] ), NULL );

	}

	return $this;

  }
  
  public function get_results(){

	return $this->results;
  }

}


class Test extends Chain {
	public function AAA () {
		
		return 'Found A';
  }

  public function BBB () {
    return 'Found B';
  }
}

$test = Chain::start()->AAA();

$test2 = Chain::start()->BBB();

$run = $test->run()->get_results();

$run2 = $test2->run()->get_results();

var_dump( $run );

var_dump( $run2 );


/*
$chain = new Chain();
$test = $chain->AAA()->BBB();

$test->go();


/* require 'class-fad-validate.php';

$test = Fad_Validate::validate( 6 )->int();

echo 'Result:';
var_dump( $test );

echo '<br /><br />';

echo 'Actions performed:';

$actions = $validate->get_actions();

print_r( $actions ); */