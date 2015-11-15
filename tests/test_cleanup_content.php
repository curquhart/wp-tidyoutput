<?php

class CleanContentTest extends WP_UnitTestCase {

    protected $tidy = null;

    public function setUp() {
        parent::setUp();

        // We're going to use the plugin directly so there is no chance of
        // broken things due to it attaching to WordPress multiple times.
        $this->tidy = TidyOutput::get_instance( false, true );

        // Configure
        $this->tidy->set_option( TidyOutput::TIDY_METHOD, 'tidy' );
        $this->tidy->set_option( TidyOutput::FORMAT, false );
        $this->tidy->set_option( TidyOutput::CLEANUP, true );
    }

    public function test_cleanup_content() {
        foreach (array( 'tidy', 'domdocument' ) as $method) {

            $method = 'clean_content_' . $method;

            // Test extra closing tag
            $result = trim( $this->tidy->$method( "<p>test</p></p>" ) );
            $this->assertSame( "<p>test</p>", $result,
                __LINE__ . ':' . $method );

            // Test missing closing tag
            $result = trim( $this->tidy->$method( "<p>test" ) );
            $this->assertSame( "<p>test</p>", $result,
                __LINE__ . ':' . $method );

            // Test mis-matched closing tag
            $result = trim( $this->tidy->$method( "<p>test</i>" ) );
            $this->assertSame( "<p>test</p>", $result,
                __LINE__ . ':' . $method );

            // Test empty tags
            $result = trim( $this->tidy->$method( "<p></p>" ) );
            $this->assertSame( "", $result, __LINE__ . ':' . $method );

            // Test empty tag with attributes
            $result = trim( $this->tidy->$method( '<p class="test"></p>' ) );
            $this->assertSame( '<p class="test"></p>', $result,
                __LINE__ . ':' . $method );

            // Test non-empty tag with attributes
            $result = trim( $this->tidy->$method( '<p>test</p>' ) );
            $this->assertSame( '<p>test</p>', $result,
                __LINE__ . ':' . $method );
        }
    }
}

