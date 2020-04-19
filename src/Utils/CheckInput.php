<?php

namespace YoutubeDownloader\Utils;

/**
 * Class CheckInput
 * @package YoutubeDownloader\Utils
 */
class CheckInput {

    /**
     * @param $inputBool bool
     * @param string $message
     *
     * @return bool
     */
    public static function checkInput($inputBool, $message = '') {
        if ($inputBool === true) {
            return true;
        }
        throw new \InvalidArgumentException($message);
    }
}
