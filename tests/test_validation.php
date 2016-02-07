<?php

namespace TidyOutput;

class ValidationTest extends \WP_UnitTestCase {

    protected $tidy = null;

    public function setUp() {
        parent::setUp();

        // We're going to use the plugin directly so there is no chance of
        // broken things due to it attaching to WordPress multiple times.
        $this->tidy = TidyOutput::get_instance( false, true );
        $this->tidy->set_option( TidyOutput::TIDY_METHOD, 'tidy' );
    }

    public function test_good_options() {
        $this->tidy->set_option( TidyOutput::FULL_PAGE, true );
        $this->tidy->set_option( TidyOutput::CLEANUP, true );
        $this->tidy->set_option( TidyOutput::FORMAT, true );
        $this->tidy->set_option( TidyOutput::EXTRANEOUS_INDENT_CONTENT, 5 );
        $this->tidy->set_option( TidyOutput::EXTRANEOUS_INDENT_COMMENT, 3 );

        $this->assertSame( 'tidy', $this->tidy->get_option(
            TidyOutput::TIDY_METHOD ) );
        $this->assertSame( true, $this->tidy->get_option(
            TidyOutput::FULL_PAGE ) );
        $this->assertSame( true, $this->tidy->get_option(
            TidyOutput::CLEANUP ) );
        $this->assertSame( true, $this->tidy->get_option(
            TidyOutput::FORMAT ) );
        $this->assertSame( 5, $this->tidy->get_option(
            TidyOutput::EXTRANEOUS_INDENT_CONTENT ) );
        $this->assertSame( 3, $this->tidy->get_option(
            TidyOutput::EXTRANEOUS_INDENT_COMMENT ) );

        // Now lets change to disabled and re-compare. This should disable
        // cleanup, format, and full page as well as they are unsupported.
        $this->tidy->set_option( TidyOutput::TIDY_METHOD, 'disable' );
        $this->tidy->set_option( TidyOutput::EXTRANEOUS_INDENT_CONTENT, 1 );
        $this->tidy->set_option( TidyOutput::EXTRANEOUS_INDENT_COMMENT, 2 );

        $this->assertSame( 'disable', $this->tidy->get_option(
            TidyOutput::TIDY_METHOD ) );
        $this->assertSame( false, $this->tidy->get_option(
            TidyOutput::FULL_PAGE ) );
        $this->assertSame( false, $this->tidy->get_option(
            TidyOutput::CLEANUP ) );
        $this->assertSame( false, $this->tidy->get_option(
            TidyOutput::FORMAT ) );
        $this->assertSame( 1, $this->tidy->get_option(
            TidyOutput::EXTRANEOUS_INDENT_CONTENT ) );
        $this->assertSame( 2, $this->tidy->get_option(
            TidyOutput::EXTRANEOUS_INDENT_COMMENT ) );
    }

    public function test_enable_unsupported_feature() {
        // This doesn't support anything
        $this->tidy->set_option( TidyOutput::TIDY_METHOD, 'disable' );

        // Now lets try to turn something (unsupported) on, to make sure the
        // option doesn't stick.
        $this->tidy->set_option( TidyOutput::FULL_PAGE, true );

        $this->assertSame( false, $this->tidy->get_option(
            TidyOutput::FULL_PAGE ) );
    }

    public function test_boolean_validator_true() {
        $this->tidy->set_option( TidyOutput::FULL_PAGE, true );
        $this->assertSame( true, $this->tidy->get_option(
            TidyOutput::FULL_PAGE ) );

        $this->tidy->set_option( TidyOutput::FULL_PAGE, 'true' );
        $this->assertSame( true, $this->tidy->get_option(
            TidyOutput::FULL_PAGE ) );

        $this->tidy->set_option( TidyOutput::FULL_PAGE, 'TRUE' );
        $this->assertSame( true, $this->tidy->get_option(
            TidyOutput::FULL_PAGE ) );

        $this->tidy->set_option( TidyOutput::FULL_PAGE, '1' );
        $this->assertSame( true, $this->tidy->get_option(
            TidyOutput::FULL_PAGE ) );
    }

    public function test_boolean_validator_false() {
        $this->tidy->set_option( TidyOutput::FULL_PAGE, false );
        $this->assertSame( false, $this->tidy->get_option(
            TidyOutput::FULL_PAGE ) );

        $this->tidy->set_option( TidyOutput::FULL_PAGE, 'false' );
        $this->assertSame( false, $this->tidy->get_option(
            TidyOutput::FULL_PAGE ) );

        $this->tidy->set_option( TidyOutput::FULL_PAGE, 'FALSE' );
        $this->assertSame( false, $this->tidy->get_option(
            TidyOutput::FULL_PAGE ) );

        $this->tidy->set_option( TidyOutput::FULL_PAGE, '0' );
        $this->assertSame( false, $this->tidy->get_option(
            TidyOutput::FULL_PAGE ) );
    }

    public function test_validator_invalid() {
        // We need to know the default because any invalid options will reset
        // to this.
        $default = $this->tidy->get_default_option( TidyOutput::FULL_PAGE );

        $this->tidy->set_option( TidyOutput::FULL_PAGE, new \DateTime() );
        $this->assertSame( $default, $this->tidy->get_option(
            TidyOutput::FULL_PAGE ) );

        $this->tidy->set_option( TidyOutput::FULL_PAGE, '5' );
        $this->assertSame( $default, $this->tidy->get_option(
            TidyOutput::FULL_PAGE ) );

        $this->tidy->set_option( TidyOutput::FULL_PAGE, 'random string' );
        $this->assertSame( $default, $this->tidy->get_option(
            TidyOutput::FULL_PAGE ) );

        $default = $this->tidy->get_default_option(
            TidyOutput::EXTRANEOUS_INDENT_CONTENT );
        $this->tidy->set_option( TidyOutput::EXTRANEOUS_INDENT_CONTENT,
            TidyOutput::MAX_EXTRANEOUS_INDENT + 1 );
        $this->assertSame( $default, $this->tidy->get_option(
            TidyOutput::EXTRANEOUS_INDENT_CONTENT ) );

        $default = $this->tidy->get_default_option(
            TidyOutput::EXTRANEOUS_INDENT_COMMENT );
        $this->tidy->set_option( TidyOutput::EXTRANEOUS_INDENT_COMMENT,
            TidyOutput::MAX_EXTRANEOUS_INDENT + 1 );
        $this->assertSame( $default, $this->tidy->get_option(
            TidyOutput::EXTRANEOUS_INDENT_COMMENT ) );

        $this->assertSame( null, $this->tidy->get_option( 'invalid' ) );
    }
}
