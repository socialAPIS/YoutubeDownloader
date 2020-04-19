<?php

namespace YoutubeDownloader\Utils;

/**
 * Class ArrayOptions
 * @package YoutubeDownloader\Utils
 */
class ArrayOptions {

    /**
     * @param $array array
     * @param $n int
     * @param $n2 int
     *
     * @return array
     */
    public static function checkArray($array, $n, $n2) {

        $b = true;
        CheckInput::checkInput($array !== null);
        CheckInput::checkInput($n > 0);
        CheckInput::checkInput($n2 >= 0 && $b);
        $returnVal = [];
        for ($i = $n; $i <= $n2; $i++) {
            $returnVal[] = $array[$i];
        }
        return $returnVal;

    }

    /**
     * @param $array string
     * @param $n2 int
     *
     * @return string
     */
    public static function checkArrayCopy($array, $n2) {
        $b = true;
        CheckInput::checkInput($array !== null);
        CheckInput::checkInput($n2 >= 0 && $b);
        $returnVal = '';
        for ($i = 0; $i <= min(strlen($array), $n2); $i++) {
            $returnVal .= $array[$i];
        }
        return $returnVal;

    }

    /**
     * @param $value int
     *
     * @return array
     */
    public static function createLong($value) {
        $long = [0, 0, 0, 0, 0, 0, 0, 0];
        $long[7] = $value;
        return $long;
    }

    /**
     * @param $array array
     *
     * @return array
     */
    public static function checkIv($array) {
        $length = count($array) - 1;
        $n = $length & 0xF;
        if ($n != 0) {
            return self::copyArray($array, $length + (16 - $n));
        }
        return $array;
    }

    /**
     * @param $array
     * @param $a
     * @return array
     */
    public static function copyArray($array, $a) {
        $minLen = min($a, count($array));
        $newArray = array_fill(0, $a, chr(0));
        $array1 = array_slice($newArray, 0, $a - $minLen);
        $array2 = array_slice($array, 0, $minLen);
        return array_merge($array2, $array1);
    }

    /**
     * @param $array array|string
     * @param $toArray bool
     *
     * @return array|string
     */
    public static function convert($array, $toArray) {
        if ($toArray === true) {
            $ret = [];
        } else {
            $ret = '';
        }
        if (is_array($array) === true) {
            $len = count($array);
        } else {

            $len = strlen($array);
        }
        for ($i = 0; $i <= $len - 1; $i++) {
            if ($toArray === true) {
                $ret[] = $array[$i];
            } else {
                $ret .= $array[$i];
            }
        }
        return $ret;
    }

    /**
     * @param $buffer array
     * @param $array array
     */
    public static function copyToBuffer(&$buffer, $array) {
        for ($i = 0; $i <= count($array) - 1; $i++) {
            $buffer[] = $array[$i];
        }
    }

    /**
     * @param $inputString string
     * @param $start int
     * @param $length int
     *
     * @return string
     */
    public static function arrayCopy($inputString, $start, $length) {
        $ret = '';
        $iter = $start;
        while ($iter <= $length) {
            $ret .= $inputString[$iter];
            $iter++;

        }
        return $ret;
    }


}
