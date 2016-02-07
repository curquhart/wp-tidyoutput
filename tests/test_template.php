<?php

namespace TidyOutput;

class DummyOutput {

    /**
     * @var string The output buffer that will be output the second time
     * this file is included
     */
    public static $output = '';

    /**
     * Sets output to the provided string
     *
     * @param string $output
     */
    public static function set_output( $output ) {
        static::$output = $output;
    }

    /**
     * Returns the output previously set
     *
     * @return string
     */
    public static function get_output() {
        return static::$output;
    }
}

class TemplateTest extends \WP_UnitTestCase {

    protected $tidy = null;

    public function setUp() {
        parent::setUp();

        // Set options
        $this->tidy = TidyOutput::get_instance();
        $this->tidy->set_option( TidyOutput::FULL_PAGE, true );
        $this->tidy->set_option( TidyOutput::CLEANUP, true );
        $this->tidy->set_option( TidyOutput::FORMAT, false );
        $this->tidy->set_option( TidyOutput::EXTRANEOUS_INDENT_CONTENT, 0 );
    }

    public function test_template() {
        // Install our filter
        $filename = apply_filters( 'template_include',
            __DIR__ . '/dummy_template.php' );

        // Set some terrible html
        DummyOutput::set_output( "<!doctype html><html><body><p>test<span></p></body>" );

        // Say we're using themes so the template is actually rendered
        define( 'WP_USE_THEMES', true );

        // Capture output
        ob_start();

        $this->tidy->set_option( TidyOutput::TIDY_METHOD, 'tidy' );
        require $filename;

        // Retrieve output
        $output = ob_get_clean();

        $this->assertRegexp( '/' . preg_quote('<p>test</p>', '/') . '/',
            $output );

        $this->assertRegexp( '/' . preg_quote('<!doctype html>', '/') . '/i',
            $output );

        // Capture output
        ob_start();

        $this->tidy->set_option( TidyOutput::TIDY_METHOD, 'domdocument' );
        require $filename;

        // Retrieve output
        $output = ob_get_clean();

        $this->assertRegexp( '/' . preg_quote('<p>test</p>', '/') . '/',
            $output );

        $this->assertRegexp( '/' . preg_quote('<!doctype html>', '/') . '/i',
            $output );
    }
}
