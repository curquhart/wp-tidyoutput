<?php

/*
Plugin Name: Tidy Output
Plugin URI: https://github.com/chelseau/wp-tidyoutput
Description: A plugin designed to cleanup HTML output
Author: Chelsea Urquhart
Text Domain: tidyoutput
Domain Path: /languages
Version: 1.0
Author URI: http://www.chelseau.com
*/

require __DIR__ . '/classes/TidyOutput.php';

// Attach plugin to WordPress
TidyOutput::attach();