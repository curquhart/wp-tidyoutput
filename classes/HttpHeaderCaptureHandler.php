<?php

namespace TidyOutput;

class HttpHeaderCaptureHandler implements HttpHeaderHandlerInterface {
    /**
     * @var array The headers that would be sent
     */
    protected $headers = array();

    /**
     * @var int The response code being sent
     */
    protected $response_code = 200;

    /**
     * Handles a header identified by $key and $value
     *
     * @param string $key The key of the header to add
     * @param string $value The value of the header to add
     * @param bool $replace Replace the existing one, or allow multiples?
     * @param int $http_response_code The response code to send
     */
    public function add_header( $key, $value, $replace = true,
            $http_response_code = 0 ) {
        if ( $replace || ! isset( $this->headers[ $key ] ) ) {
            $this->headers[ $key ] = array();
        }

        $this->headers[ $key ][] = (string) $value;

        if ( ! empty( $http_response_code ) ) {
            $this->response_code = $http_response_code;
        }
    }

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
    public function get_header( $key, $multiple = false ) {
        if ( ! isset( $this->headers[ $key ] ) ) {
            return $multiple ? array() : null;
        }

        if ( $multiple ) {
            return $this->headers[ $key ];
        } else {
            return end( $this->headers[ $key ] );
        }
    }
}
