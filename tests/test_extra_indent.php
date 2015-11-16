<?php

namespace TidyOutput;

class ExtraIndentTest extends \WP_UnitTestCase {

    const INDENT_LEVEL = 3;

    protected $tidy = null;

    public function setUp() {
        parent::setUp();

        // We're going to use the plugin directly so there is no chance of
        // broken things due to it attaching to WordPress multiple times.
        $this->tidy = TidyOutput::get_instance( false, true );

        $this->tidy->set_option( TidyOutput::TIDY_METHOD, 'tidy' );
        $this->tidy->set_option( TidyOutput::EXTRANEOUS_INDENT,
            static::INDENT_LEVEL );
        $this->indents = str_repeat( ' ', static::INDENT_LEVEL * 4 );
    }

    public function test_oneline() {
       $result = $this->tidy->indent_content( "<p>test</p>" );
        $this->assertSame( $this->indents . "<p>test</p>", $result );
    }

    public function test_twoline_cr() {
        $result = $this->tidy->indent_content( "<p>test</p>\r<p>test2</p>" );
        $this->assertSame( $this->indents . "<p>test</p>\r"
                             . $this->indents . "<p>test2</p>", $result );
    }

    public function test_twoline_lf() {
        $result = $this->tidy->indent_content( "<p>test</p>\n<p>test2</p>" );
        $this->assertSame( $this->indents . "<p>test</p>\n"
                             . $this->indents . "<p>test2</p>", $result );
    }

    public function test_twoline_crlf() {
        $result = $this->tidy->indent_content( "<p>test</p>\r\n<p>test2</p>" );
        $this->assertSame( $this->indents . "<p>test</p>\r\n"
                             . $this->indents . "<p>test2</p>", $result );
    }

    public function test_twoline_lfcr() {
        $result = $this->tidy->indent_content( "<p>test</p>\n\r<p>test2</p>" );
        $this->assertSame( $this->indents . "<p>test</p>\n\r"
                             . $this->indents . "<p>test2</p>", $result );
    }

    public function test_twoline_lflf() {
        $result = $this->tidy->indent_content( "<p>test</p>\n\n<p>test2</p>" );
        $this->assertSame( $this->indents . "<p>test</p>\n\n"
                             . $this->indents . "<p>test2</p>", $result );
    }

    public function test_twoline_crcr() {
        $result = $this->tidy->indent_content( "<p>test</p>\r\r<p>test2</p>" );
        $this->assertSame( $this->indents . "<p>test</p>\r\r"
                             . $this->indents . "<p>test2</p>", $result );
    }
}

