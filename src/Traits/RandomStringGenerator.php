<?php

namespace YoutubeDownloader\Traits;

trait RandomStringGenerator {

    /**
     * @var $data string
     */
    protected $data = '0123456789abcdefghijklmnopqrstuvwxyz';

    /**
     * @param $length int
     *
     * @return string
     *
     * @throws \Exception
     */
    function random_str($length) {
        $str = '';
        $max = mb_strlen($this->data, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $this->data[random_int(0, $max)];
        }
        return $str;
    }
}
