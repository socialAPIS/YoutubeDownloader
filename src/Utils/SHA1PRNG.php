<?php

namespace YoutubeDownloader\Utils;

/**
 * Class SHA1PRNG
 * @package YoutubeDownloader\Utils
 */
class SHA1PRNG {

    /**
     * @var int
     */
    public $length;

    /**
     * SHA1PRNG constructor.
     * @param $length
     */
    public function __construct($length = 9) {
        $this->length = $length;
    }

    /**
     * @param $length int
     *
     * @return SHA1PRNG
     */
    public static function getInstance($length = 9) {
        return new self($length);
    }


    /**
     * @return string
     * @throws \Exception
     */
    public function nextBytes() {
        $btLength = $this->length;
        $bt = [];
        $index = 0;
        $DIGEST_SIZE = $this->length;


        $seed = random_bytes($this->length);

        $state = self::getBytes(openssl_digest($seed, 'sha1', true));

        while ($index < $btLength) {
            $output = self::getBytes(openssl_digest(self::toStr($state), 'sha1', true));

            $state = self::updateState($state, $output);
            $tdo = ($btLength - $index) > $DIGEST_SIZE ? $DIGEST_SIZE : $btLength - $index;
            // Copy the bytes, zero the buffer
            for ($i = 0; $i < $tdo; $i++) {
                $bt[$index++] = $output[$i];
                $output[$i] = 0;
            }
        }

        return self::toStr($bt);
    }

    /**
     * @param $state
     * @param $output
     * @return mixed
     */
    private function updateState($state, $output) {
        $last = 1;
        $zf = false;
        // state(n + 1) = (state(n) + output(n) + 1) % 2^160;
        for ($i = 0; $i < count($state); $i++) {
            // Add two bytes
            $v = self::getInt8($state[$i]) + self::getInt8($output[$i]) + $last;
            // Result is lower 8 bits
            $t = $v & 255;
            // Store result. Check for state collision.
            $zf = $zf | ($state[$i] != $t);
            $state[$i] = $t;
            // High 8 bits are carry. Store for next iteration.
            $last = $v >> 8;
        }
        // Make sure at least one bit changes!
        if (!$zf)
            $state[0]++;
        return $state;
    }

    /**
     * @param $num
     * @return int
     */
    private function getInt8($num) {
        if ($num > 127) {
            return $num - 256;
        }
        return $num;
    }

    /**
     * @param $str
     * @return array
     */
    private function getBytes($str) {
        $bytes = array();
        for ($i = 0; $i < strlen($str); $i++) {
            $bytes[] = ord($str[$i]);
        }
        return $bytes;
    }

    /**
     * @param $bytes
     * @return string
     */
    private function toStr($bytes) {
        $str = '';
        foreach ($bytes as $ch) {
            $str .= chr($ch);
        }

        return $str;
    }
}
