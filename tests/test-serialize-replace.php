<?php
require_once(__DIR__. '/../src/functions.php');


class Serialization_Nested {
	private $search = null;

	public function __construct( $search ) {
		$this->search = serialize( $search );
	}
}
class Serialization_Test {
	private $search = null;
	private $nested = null;

	public function __construct( $search ) {
		$this->search = serialize( $search );
		$this->nested = serialize( new Serialization_Nested( $search ) );
	}
}

class Test_Serialize_Replace extends PHPUnit_Framework_TestCase {
	/**
	 * @dataProvider serialization_provider
	 */
	public function test_replace_serialized_values( $search, $replace, $serialized, $expected ) {
	    if (is_array($search) && is_array($replace)) {
            $this->assertSame($expected, strtr_serialized($serialized, array_combine($search, $replace)));
        } else {
            $this->assertSame($expected, strtr_serialized($serialized, array($search => $replace) ));
        }
	}

	public function serialization_provider() {
		return array(
			array(
				'https://google.com',
				'https://facebook.com',
				serialize( new Serialization_Test( 'https://google.com' ) ),
				serialize( new Serialization_Test( 'https://facebook.com' ) ),
			),
			array(
				'https://google.com/wordpress',
				'https://facebook.com',
				serialize( new Serialization_Test( 'https://google.com/wordpress' ) ),
				serialize( new Serialization_Test( 'https://facebook.com' ) ),
			),
			array(
				'https://google.com',
				'https://facebook.com/wordpress',
				serialize( new Serialization_Test( 'https://google.com' ) ),
				serialize( new Serialization_Test( 'https://facebook.com/wordpress' ) ),
			),
			array(
				'https://google.com/wordpress',
				'https://facebook.com/wordpress',
				serialize( new Serialization_Test( 'https://google.com/wordpress' ) ),
				serialize( new Serialization_Test( 'https://facebook.com/wordpress' ) ),
			),
			array(
				'https://google.com/wordpress/wordpress',
				'https://facebook.com/wordpress/wordpress',
				serialize( new Serialization_Test( 'https://google.com/wordpress/wordpress' ) ),
				serialize( new Serialization_Test( 'https://facebook.com/wordpress/wordpress' ) ),
			),
			array(
				':2:3',
				':3:2',
				serialize( new Serialization_Test( ':2:3' ) ),
				serialize( new Serialization_Test( ':3:2' ) ),
			),
			array(
				'{username}',
				'{user}',
				serialize( new Serialization_Test( '{username}' ) ),
				serialize( new Serialization_Test( '{user}' ) ),
			),
			array(
				'https://google.com/wordpress/wordpress',
				'https://facebook.com/wordpress/wordpress',
				serialize( new Serialization_Test( 'test s: str : 123 : https://google.com/wordpress/wordpress 456:' ) ),
				serialize( new Serialization_Test( 'test s: str : 123 : https://facebook.com/wordpress/wordpress 456:' ) ),
			),
			array(
				'https://google.com/wordpress/wordpress',
				'https://facebook.com/wordpress/wordpress',
				serialize( array( 'https://google.com/wordpress/wordpress' ) ),
				serialize( array( 'https://facebook.com/wordpress/wordpress' ) ),
			),
            array(
                array(
                    'https://domain.tld',
                    'https://www.domain.tld',
                ),
                array(
                    'http://domain.tld',
                    'http://domain.tld',
                ),
                serialize( 'https://domain.tld https://www.domain.tld' ),
                serialize( 'http://domain.tld http://domain.tld' ),
            ),
		);
	}
}
