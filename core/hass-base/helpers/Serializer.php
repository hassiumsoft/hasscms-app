<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link      http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2014-2099  Hassium  Software LLC.
 * @license   http://www.hassium.org/license/new-bsd New BSD License
 */

namespace hass\base\helpers;

/**
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Serializer
{

    /**
     *
     * @param unknown $value
     * @return String
     */
    public static function serialize($value) {

        return static::maybeSerialize($value);
    }

    /**
     *
     *
     * @param string $value
     * @return Array
     */
    public static function unserialize($value) {
        return static::maybeUnserialize($value);
    }

    /**
     *
     *
     * @param string $value
     * @return Array
     */
    public static function unserializeToArray($value) {
      $result =  static::maybeUnserialize($value);

      if(empty($result))
      {
        $result = [];
      }

      return (Array)$result;
    }

    /**
     *
     * @param unknown $data
     * @param string $strict
     * @return boolean
     */
    public static function isSerialized( $data, $strict = true ) {
        // if it isn't a string, it isn't serialized
        if ( ! is_string( $data ) )
            return false;
        $data = trim( $data );
        if ( 'N;' == $data )
            return true;
        $length = strlen( $data );
        if ( $length < 4 )
            return false;
        if ( ':' !== $data[1] )
            return false;
        if ( $strict ) {
            $lastc = $data[ $length - 1 ];
            if ( ';' !== $lastc && '}' !== $lastc )
                return false;
        } else {
            $semicolon = strpos( $data, ';' );
            $brace     = strpos( $data, '}' );
            // Either ; or } must exist.
            if ( false === $semicolon && false === $brace )
                return false;
            // But neither must be in the first X characters.
            if ( false !== $semicolon && $semicolon < 3 )
                return false;
            if ( false !== $brace && $brace < 4 )
                return false;
        }
        $token = $data[0];
        switch ( $token ) {
        	case 's' :
        	    if ( $strict ) {
        	        if ( '"' !== $data[ $length - 2 ] )
        	            return false;
        	    } elseif ( false === strpos( $data, '"' ) ) {
        	        return false;
        	    }
        	    // or else fall through
        	case 'a' :
        	case 'O' :
        	    return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
        	case 'b' :
        	case 'i' :
        	case 'd' :
        	    $end = $strict ? '$' : '';
        	    return (bool) preg_match( "/^{$token}:[0-9.E-]+;$end/", $data );
        }
        return false;
    }

    /**
     *
     * @param unknown $data
     * @return boolean
     */
    public static function isSerializedString( $data ) {
        // if it isn't a string, it isn't a serialized string
        if ( !is_string( $data ) )
            return false;
        $data = trim( $data );
        $length = strlen( $data );
        if ( $length < 4 ){
            return false;
        }
        elseif ( ':' !== $data[1] ){
            return false;
        }
        elseif ( ';' !== $data[$length-1] ){
            return false;
        }

        elseif ( $data[0] !== 's' ){
            return false;
        }

        elseif ( '"' !== $data[$length-2] ){
            return false;
        }

        else{
            return true;
        }

    }

    /**
     *
     * @param unknown $original
     * @return unknown
     */
    public static function maybeUnserialize( $original ) {
        if ( static::isSerialized( $original ) ) // don't attempt to unserialize data that wasn't serialized going in
            return @unserialize( $original );
        return $original;
    }

    /**
     *
     * @param unknown $data
     * @return string|unknown
     */
    public static function maybeSerialize( $data ) {
        if ( is_array( $data ) || is_object( $data ) )
            return serialize( $data );

        // Double serialization is required for backward compatibility.
        // See http://core.trac.wordpress.org/ticket/12930
        if ( static::isSerialized( $data, false ) )
            return serialize( $data );

        return $data;
    }
}