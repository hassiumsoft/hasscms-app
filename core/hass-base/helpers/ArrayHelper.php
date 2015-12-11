<?php
/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2014-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base\helpers;

use Traversable;
use yii\base\InvalidParamException;


/**
* @package hass\base\helpers
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class ArrayHelper extends  \yii\helpers\ArrayHelper
{
    /**
     * Test whether an array contains one or more string keys
     *
     * @param  mixed $value
     * @param  bool  $allowEmpty    Should an empty array() return true
     * @return bool
     */
    public static function hasStringKeys($value, $allowEmpty = false)
    {
        if (!is_array($value)) {
            return false;
        }

        if (!$value) {
            return $allowEmpty;
        }

        return count(array_filter(array_keys($value), 'is_string')) > 0;
    }

    /**
     * Test whether an array contains one or more integer keys
     *
     * @param  mixed $value
     * @param  bool  $allowEmpty    Should an empty array() return true
     * @return bool
     */
    public static function hasIntegerKeys($value, $allowEmpty = false)
    {
        if (!is_array($value)) {
            return false;
        }

        if (!$value) {
            return $allowEmpty;
        }

        return count(array_filter(array_keys($value), 'is_int')) > 0;
    }

    /**
     * Test whether an array contains one or more numeric keys.
     *
     * A numeric key can be one of the following:
     * - an integer 1,
     * - a string with a number '20'
     * - a string with negative number: '-1000'
     * - a float: 2.2120, -78.150999
     * - a string with float:  '4000.99999', '-10.10'
     *
     * @param  mixed $value
     * @param  bool  $allowEmpty    Should an empty array() return true
     * @return bool
     */
    public static function hasNumericKeys($value, $allowEmpty = false)
    {
        if (!is_array($value)) {
            return false;
        }

        if (!$value) {
            return $allowEmpty;
        }

        return count(array_filter(array_keys($value), 'is_numeric')) > 0;
    }

    /**
     * Test whether an array is a list
     *
     * A list is a collection of values assigned to continuous integer keys
     * starting at 0 and ending at count() - 1.
     *
     * For example:
     * <code>
     * $list = array('a', 'b', 'c', 'd');
     * $list = array(
     *     0 => 'foo',
     *     1 => 'bar',
     *     2 => array('foo' => 'baz'),
     * );
     * </code>
     *
     * @param  mixed $value
     * @param  bool  $allowEmpty    Is an empty list a valid list?
     * @return bool
     */
    public static function isList($value, $allowEmpty = false)
    {
        if (!is_array($value)) {
            return false;
        }

        if (!$value) {
            return $allowEmpty;
        }

        return (array_values($value) === $value);
    }

    /**
     * Test whether an array is a hash table.
     *
     * An array is a hash table if:
     *
     * 1. Contains one or more non-integer keys, or
     * 2. Integer keys are non-continuous or misaligned (not starting with 0)
     *
     * For example:
     * <code>
     * $hash = array(
     *     'foo' => 15,
     *     'bar' => false,
     * );
     * $hash = array(
     *     1995  => 'Birth of PHP',
     *     2009  => 'PHP 5.3.0',
     *     2012  => 'PHP 5.4.0',
     * );
     * $hash = array(
     *     'formElement,
     *     'options' => array( 'debug' => true ),
     * );
     * </code>
     *
     * @param  mixed $value
     * @param  bool  $allowEmpty    Is an empty array() a valid hash table?
     * @return bool
     */
    public static function isHashTable($value, $allowEmpty = false)
    {
        if (!is_array($value)) {
            return false;
        }

        if (!$value) {
            return $allowEmpty;
        }

        return (array_values($value) !== $value);
    }

    /**
     * Checks if a value exists in an array.
     *
     * Due to "foo" == 0 === TRUE with in_array when strict = false, an option
     * has been added to prevent this. When $strict = 0/false, the most secure
     * non-strict check is implemented. if $strict = -1, the default in_array
     * non-strict behaviour is used.
     *
     * @param mixed $needle
     * @param array $haystack
     * @param int|bool $strict
     * @return bool
     */
    public static function inArray($needle, array $haystack, $strict = false)
    {
        if (!$strict) {
            if (is_int($needle) || is_float($needle)) {
                $needle = (string) $needle;
            }
            if (is_string($needle)) {
                foreach ($haystack as &$h) {
                    if (is_int($h) || is_float($h)) {
                        $h = (string) $h;
                    }
                }
            }
        }
        return in_array($needle, $haystack, $strict);
    }

    /**
     * Convert an iterator to an array.
     *
     * Converts an iterator to an array. The $recursive flag, on by default,
     * hints whether or not you want to do so recursively.
     *
     * @param  array|Traversable  $iterator     The array or Traversable object to convert
     * @param  bool               $recursive    Recursively check all nested structures
     * @throws Exception\InvalidArgumentException if $iterator is not an array or a Traversable object
     * @return array
     */
    public static function iteratorToArray($iterator, $recursive = true)
    {
        if (!is_array($iterator) && !$iterator instanceof Traversable) {
            throw new InvalidParamException(__METHOD__ . ' expects an array or Traversable object');
        }

        if (!$recursive) {
            if (is_array($iterator)) {
                return $iterator;
            }

            return iterator_to_array($iterator);
        }

        if (method_exists($iterator, 'toArray')) {
            return $iterator->toArray();
        }

        $array = array();
        foreach ($iterator as $key => $value) {
            if (is_scalar($value)) {
                $array[$key] = $value;
                continue;
            }

            if ($value instanceof Traversable) {
                $array[$key] = static::iteratorToArray($value, $recursive);
                continue;
            }

            if (is_array($value)) {
                $array[$key] = static::iteratorToArray($value, $recursive);
                continue;
            }

            $array[$key] = $value;
        }

        return $array;
    }


    /**
     *[
     *  ["id"=>3]
     *  ["id"=>4]
     *]
     *
     * list($key,$value) = locationByindex($array,$id,3)
     * @param unknown $array
     * @param unknown $index
     * @param unknown $value
     * @return multitype:unknown
     */
    public static function locationByindex($array,$index,$value)
    {
        $location = [];
        foreach ($array as $key => $element) {
             if(static::getValue($element, $index) == $value)
             {
                 $location[] = $key;
                 $location[]=$element;
             }
        }

        return $location;
    }


    public static function insertBefore($input, $index, $newKey, $element) {

        $tmpArray = array();
        foreach ($input as $key => $value) {
            if ($key === $index) {
                $tmpArray[$newKey] = $element;
            }
            $tmpArray[$key] = $value;
        }
        return $tmpArray;
    }

   public static  function insertAfter($input, $index, $newKey, $element) {

        $tmpArray = array();
        foreach ($input as $key => $value) {
            $tmpArray[$key] = $value;
            if ($key === $index) {
                $tmpArray[$newKey] = $element;
            }
        }
        return $tmpArray;
    }

   public static function insertPosition(&$array, $position, $newKey, $element)
    {
        if (is_int($position)) {
            array_splice($array, $position, 0, $element);
        } else {
            $pos   = array_search($position, array_keys($array));
            $array = array_merge(
                array_slice($array, 0, $pos),
                [$newKey=>$element],
                array_slice($array, $pos)
            );
        }
    }

}
