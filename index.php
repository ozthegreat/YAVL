<?php

/**
 * TODO:
 * 
 * Define Error messages at a class level. Allow params to be passed
 * Change returned options (boolean).
 * Break on first error.
 * How it stores error, show values passed for each individual functions
 * 
 */

require 'class-fad-validate.php';

$checkPrime = Fad_Validate::initialize()->prime();

var_dump( $checkPrime->validate( array( 12345678919 ) ) );
print_r( $checkPrime->get_actions() );
die;
$query_chain = Fad_Validate::initialize()->int()->between( 12, 20 )->lessThan( 17 )->greaterThan( 13 );

$query_chain->validate( array( 12, 67 ) );

$second_query_chain = Fad_Validate::initialize()->int()->between( 12, 20 )->lessThan( 17 )->greaterThan( 13 )->breakFirst();

$second_query_chain->validate( 20 );

echo 'First Chain All Actions:';
echo '<br /><br />';
print_r( $query_chain->get_actions() );
echo '<br /><br />';
echo '<br /><br />';
echo 'First Chain All Errors:';
echo '<br /><br />';
print_r( $query_chain->get_errors() );

echo '<br /><br />';
echo '<br /><br />';
echo '<br /><br />';
echo '<br /><br />';

echo 'First Chain All Actions:';
echo '<br /><br />';
print_r( $second_query_chain->get_actions() );
echo '<br /><br />';
echo '<br /><br />';
echo 'First Chain All Errors:';
echo '<br /><br />';
print_r( $second_query_chain->get_errors() );
die;


/**
Types

v::arr()
v::bool()
v::date()
v::float()
v::hexa() (deprecated)
v::instance()
v::int()
v::nullValue()
v::numeric()
v::object()
v::string()
v::xdigit()
Generics

v::call()
v::callback()
v::not()
v::when()
v::alwaysValid()
v::alwaysInvalid()

Comparing Values

// v::between()
// v::equals()
v::max()
v::min()

Numeric

// v::between()
// v::bool()
// v::even()
v::float()
v::hexa() (deprecated)
// v::int()
// v::multiple()
// v::negative()
// v::notEmpty()
v::numeric()
// v::odd()
v::perfectSquare()
// v::positive()
// v::primeNumber()
v::roman()
v::xdigit()


String

v::alnum()
v::alpha()
v::between()
v::charset()
v::consonants() (deprecated)
v::consonant()
v::contains()
v::cntrl()
v::digits() (deprecated)
v::digit()
v::endsWith()
v::in()
v::graph()
v::length()
v::lowercase()
v::notEmpty()
v::noWhitespace()
v::prnt()
v::punct()
v::regex()
v::slug()
v::space()
v::startsWith()
v::uppercase()
v::uppercase()
v::version()
v::vowels() (deprecated)
v::vowel()
v::xdigit()
Arrays

v::arr()
v::contains()
v::each()
v::endsWith()
v::in()
v::key()
v::length()
v::notEmpty()
v::startsWith()
Objects

v::attribute()
v::instance()
v::length()
Date and Time

v::between()
v::date()
v::leapDate()
v::leapYear()
Group Validators

v::allOf()
v::noneOf()
v::oneOf()
Regional

v::tld()
v::countryCode()
Files

v::directory()
v::exists()
v::file()
v::readable()
v::symbolicLink()
v::uploaded()
v::writable()
Other

v::cnh()
v::cnpj()
v::cpf()
v::domain()
v::email()
v::ip()
v::json()
v::macAddress()
v::phone()
v::sf()
v::zend()
* 
* 
**/