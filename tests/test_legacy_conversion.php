<?php

namespace TidyOutput;

class LegacyConversionTest extends \WP_UnitTestCase {

    protected $tidy = null;

    public function setUp() {
        parent::setUp();

        // We're going to use the plugin directly so there is no chance of
        // broken things due to it attaching to WordPress multiple times.
        $this->tidy = TidyOutput::get_instance( false, true );
    }

    public function test_convertindent() {
        $this->tidy->set_option( TidyOutput::EXTRANEOUS_INDENT_COMMENT, 1 );
        $this->tidy->set_option( TidyOutput::EXTRANEOUS_INDENT_LEGACY, 5 );

        // The legacy option should be removed. Content should be replaced and
        // comments unaffected.
        $this->assertNull( $this->tidy->get_option(TidyOutput::EXTRANEOUS_INDENT_LEGACY ) );
        $this->assertSame( 5, $this->tidy->get_option(TidyOutput::EXTRANEOUS_INDENT_CONTENT ) );
        $this->assertSame( 1, $this->tidy->get_option(TidyOutput::EXTRANEOUS_INDENT_COMMENT ) );
    }
}

