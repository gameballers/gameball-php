<?php

namespace Gameball\Util;


abstract class Util
{

    /**
    * extracting info from the date like year , month , day , hours , minutes , seconds to be used in bodyHasing
    */
    public static function extractDateInfo(string $UTC_Date){

        $yy = \substr($UTC_Date , 2 , 2); // (str , start idx , length) for substr method
        $MM = \substr($UTC_Date , 5 , 2);
        $dd = \substr($UTC_Date , 8 , 2);
        $HH = \substr($UTC_Date , 11 , 2);
        $mm = \substr($UTC_Date , 14 , 2);
        $ss = \substr($UTC_Date , 17 , 2);
        return $yy.$MM.$dd.$HH.$mm.$ss;
    }

    /**
    * check for correct email format ---> (letters|numbers|+|_|-)+ then (.(letters|numbers|+|_|-)+)* then @ ((letters|number)+ then (.))+ and finally (letters) of length min 2 max 6
    * + means one or more repetition
    * * means zero or more repetition
    */
    public static function validEmail(string $email){
          return \preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i", $email);
    }


    /**
    * check for whilte spaces in strings
    */
    public static function containsWhitespace(string $str){
        return \preg_match('/\s/',$str);
    }


    // The following methods are for encoding paramters using URL encoding

    // /**
    //  * @param array $params
    //  *
    //  * @return string
    //  */
    // public static function encodeParameters($params)
    // {
    //     $flattenedParams = self::flattenParams($params);
    //     $pieces = [];
    //     foreach ($flattenedParams as $param) {
    //         list($k, $v) = $param;
    //         \array_push($pieces, self::urlEncode($k) . '=' . self::urlEncode($v));
    //     }
    //
    //     return \implode('&', $pieces);
    // }


    // /**
    //  * @param array $params
    //  * @param null|string $parentKey
    //  *
    //  * @return array
    //  */
    // public static function flattenParams($params, $parentKey = null)
    // {
    //     $result = [];
    //
    //     foreach ($params as $key => $value) {
    //         $calculatedKey = $parentKey ? "{$parentKey}[{$key}]" : $key;
    //
    //         if (self::isList($value)) {
    //             $result = \array_merge($result, self::flattenParamsList($value, $calculatedKey));
    //         } elseif (\is_array($value)) {
    //             $result = \array_merge($result, self::flattenParams($value, $calculatedKey));
    //         } else {
    //             \array_push($result, [$calculatedKey, $value]);
    //         }
    //     }
    //
    //     return $result;
    // }



    // /**
    //  * @param array $value
    //  * @param string $calculatedKey
    //  *
    //  * @return array
    //  */
    // public static function flattenParamsList($value, $calculatedKey)
    // {
    //     $result = [];
    //
    //     foreach ($value as $i => $elem) {
    //         if (self::isList($elem)) {
    //             $result = \array_merge($result, self::flattenParamsList($elem, $calculatedKey));
    //         } elseif (\is_array($elem)) {
    //             $result = \array_merge($result, self::flattenParams($elem, "{$calculatedKey}[{$i}]"));
    //         } else {
    //             \array_push($result, ["{$calculatedKey}[{$i}]", $elem]);
    //         }
    //     }
    //
    //     return $result;
    // }



    // /**
    //  * Whether the provided array (or other) is a list rather than a dictionary.
    //  * A list is defined as an array for which all the keys are consecutive
    //  * integers starting at 0. Empty arrays are considered to be lists.
    //  *
    //  * @param array|mixed $array
    //  *
    //  * @return bool true if the given object is a list
    //  */
    // public static function isList($array)
    // {
    //     if (!\is_array($array)) {
    //         return false;
    //     }
    //     if ($array === []) {
    //         return true;
    //     }
    //     if (\array_keys($array) !== \range(0, \count($array) - 1)) {
    //         return false;
    //     }
    //
    //     return true;
    // }


    // /**
    //  * @param string $key a string to URL-encode
    //  *
    //  * @return string the URL-encoded string
    //  */
    // public static function urlEncode($key)
    // {
    //     $s = \urlencode((string) $key);
    //
    //     // Don't use strict form encoding by changing the square bracket control
    //     // characters back to their literals. This is fine by the server, and
    //     // makes these parameter strings easier to read.
    //     $s = \str_replace('%5B', '[', $s);
    //
    //     return \str_replace('%5D', ']', $s);
    // }
}
