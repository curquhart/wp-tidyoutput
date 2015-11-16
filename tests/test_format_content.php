<?php

class FormatContentTest extends WP_UnitTestCase {

    protected $tidy = null;

    public function setUp() {
        parent::setUp();

        // We're going to use the plugin directly so there is no chance of
        // broken things due to it attaching to WordPress multiple times.
        $this->tidy = TidyOutput::get_instance( false, true );

        // Configure
        $this->tidy->set_option( TidyOutput::TIDY_METHOD, 'tidy' );
        $this->tidy->set_option( TidyOutput::FORMAT, true );
        $this->tidy->set_option( TidyOutput::CLEANUP, false );
    }

    public function test_format_content() {
        // DOMDocument is not supported for formatting
        $raw = "<div><p>123</p></div>";
        $result = $this->tidy->clean_content_domdocument( $raw );
        $this->assertSame( $raw, $result );

        // Tidy sure is though!
        $result = $this->tidy->clean_content_tidy( $raw );
        $result = str_replace( "\r", '', $result );
        $this->assertSame( "<div>\n    <p>123</p>\n</div>", $result );
    }
}

