<?php

namespace TidyOutput;

class JavaScriptTest extends \WP_UnitTestCase {

    protected $tidy = null;

    public function setUp() {
        parent::setUp();

        // Set options
        $this->tidy = TidyOutput::get_instance();
    }

    public function test_headers() {
        $this->tidy->register_handler( 'http_header',
            'HttpHeaderCaptureHandler' );

        // Capture output
        ob_start();

        // Require JavaScript file
        require dirname( __DIR__ ) . '/views/settings_form.js.php';

        // Discard output
        ob_end_clean();

        $handler = $this->tidy->get_handler( 'http_header' );

        $this->assertNotNull( $handler );

        $this->assertInstanceOf( 'TidyOutput\\HttpHeaderHandlerInterface',
            $handler );

        $this->assertSame( 'application/javascript',
            $handler->get_header( 'Content-Type' ) );

        $cache_control = $handler->get_header( 'Cache-Control' );

        list ( $key, $value ) = explode( '=', $cache_control, 2 );

        $this->assertSame( 'max-age', $key );
        $this->assertEquals( TidyOutput::JAVASCRIPT_EXPIRES_MINUTES * 60,
            $value );

        $expires = $handler->get_header( 'Expires' );

        // Convert to timestamp
        $expires = strtotime( $expires );

        // +/1 10 seconds
        $min_time = time() + TidyOutput::JAVASCRIPT_EXPIRES_MINUTES * 60 - 10;
        $max_time = $min_time + 20;

        $this->assertGreaterThanOrEqual( $min_time, $expires );
        $this->assertLessThanOrEqual( $max_time, $expires );
    }
}
