<?php

namespace TidyOutput;

interface HttpHeaderHandlerInterface {
    /**
     * Handles a header identified by $key and $value
     *
     * @param string $key The key of the header to add
     * @param string $value The value of the header to add
     * @param bool $replace Replace the existing one, or allow multiples?
     * @param int $http_response_code The response code to send
     */
    public function add_header( $key, $value, $replace = true,
        $http_response_code = 0 );

    /**
     * Returns previously sent headers, identified by $key. If $multiple is set,
     * this returns an array (can be empty if it was not sent). If $multiple
     * is false then this always returns a string if previously set or null
     *
     * @param string $key
     * @param bool $multiple
     *
     * @return array|string|null
     */
    public function get_header( $key, $multiple = false );
}
