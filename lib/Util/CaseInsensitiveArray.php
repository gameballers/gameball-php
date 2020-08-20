<?php

namespace GameBall\Util;

/**
 * CaseInsensitiveArray is an array-like class that ignores case for keys.
 *
 * It is used to store HTTP headers. Per RFC 2616, section 4.2:
 * Each header field consists of a name followed by a colon (":") and the field value. Field names
 * are case-insensitive.
 *
 * In the context of SDK, this is useful because the API may return headers with different
 * case depending on whether HTTP/2 is used or not (with HTTP/2, headers are always in lowercase).
 */
class CaseInsensitiveArray implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /** @var $container: The container that holds the CaseInsensitiveArray elements **/
    private $container = [];


    /** constructor with initial array or empty array(by default) **/
    public function __construct($initial_array = [])
    {
        //make the case of all the initial keys to be lower case
        $this->container = \array_change_key_case($initial_array, \CASE_LOWER);
    }

    /** @return int: the number of elements **/
    public function count()
    {
        return \count($this->container);
    }

    /** @return ArrayIterator: to iterate over the elements **/
    public function getIterator()
    {
        return new \ArrayIterator($this->container);
    }

    /** put the (key,val)=($offset,$value) pair in the CaseInsensitiveArray
     * @param $offset: the key that will be converted to lower case if string
     * @param $value: the value correponding to the $offset key
     */
    public function offsetSet($offset, $value)
    {
        $offset = static::maybeLowercase($offset);
        if (null === $offset) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /** @return bool specify whether $offset exist (case-insensitively) in the array or not**/
    public function offsetExists($offset)
    {
        $offset = static::maybeLowercase($offset);

        return isset($this->container[$offset]);
    }

    /** unset the key equal to (case-insensitively) $offset**/
    public function offsetUnset($offset)
    {
        $offset = static::maybeLowercase($offset);
        unset($this->container[$offset]);
    }

    /** @return Object: the value corresponding to the key $offset (case-insensitively)**/
    public function offsetGet($offset)
    {
        $offset = static::maybeLowercase($offset);

        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /** @param $v: if(string) {convert it to lower case} else {keep it as it is}**/
    private static function maybeLowercase($v)
    {
        if (\is_string($v)) {
            return \strtolower($v);
        }

        return $v;
    }
}
