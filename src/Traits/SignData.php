<?php

namespace YoutubeDownloader\Traits;

use YoutubeDownloader\Utils\ArrayOptions;

/**
 * Trait SignData
 * @package YoutubeDownloader\Traits
 */
trait SignData {

    /**
     * @var string
     */
    protected $algorithm = "SHA1";

    /**
     * @param $data string to be encrypted
     * @param $key string key
     * @param $length int [option] 4 or 20
     *                    4 is used to sign the url
     *                    and 20 to sign the body
     *
     * @return string the encrypted data
     */
    public function sign($data, $key, $length) {
        $dataArray = ArrayOptions::convert($data, true);
        $dataArray = ArrayOptions::copyArray($dataArray, count($dataArray)+1);
        $dataArray = ArrayOptions::convert($dataArray, false);

        $signed = hash_hmac($this->algorithm, $dataArray, $key, true);

        if ($length !== 20) {
            $signed = $this->extract($signed, $length, false);
        }

        $return = [chr(0)];
        $digest = openssl_digest($key, 'SHA1', true);

        $digest4 = ArrayOptions::copyArray(ArrayOptions::convert($digest, true), 4);
        $signed = ArrayOptions::convert($signed, true);

        foreach ($digest4 as $chr) {
            $return[] = $chr;
        }
        foreach ($signed as $chr) {
            $return[] = $chr;
        }

        return base64_encode(ArrayOptions::convert($return, false));

    }

    /**
     * @param $data
     * @param $length
     * @param bool $retArray
     * @return array|string
     */
    private function extract($data, $length, $retArray = false) {
        $ret = ArrayOptions::copyArray(ArrayOptions::convert($data, true), $length);
        if ($retArray === false) {
            $ret = ArrayOptions::convert($ret, false);
        }
        return $ret;
    }
}
