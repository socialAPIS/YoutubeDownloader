<?php

namespace YoutubeDownloader\Utils;

use YoutubeDownloader\Constants\Constants;

/**
 * Class DeviceRegistrationHelper
 * @package YoutubeDownloader\Utils
 */
class DeviceRegistrationHelper {

    /**
     * @var $id string
     */
    protected $id;
    /**
     * @var $key string
     */
    protected $key;
    /**
     * @var $project_key array
     */
    protected $project_key;
    /**
     * @var $key_digest_check string
     */
    protected $key_digest_check;
    /**
     * @var $AESKEY string
     */
    protected $AESKEY;
    /**
     * @var $HmacSHA1Key string
     */
    protected $HmacSHA1Key;

    /**
     * DeviceRegistration constructor.
     * @param $device_id
     * @param $key
     */
    public function __construct($device_id, $key) {
        $this->id = $device_id;
        $this->key = $key;
        $data = base64_decode(Constants::YOUTUBE_PROJECT_KEY);
        for ($i = 0; $i <= strlen($data) - 1; $i++) {
            $this->project_key[] = $data[$i];
        }
        $this->prepareProjectKeys();

    }


    /**
     * This function prepare the key for encryption
     */
    protected function prepareProjectKeys() {
        $project_ley_length = count($this->project_key);

        $project_key_validation = !($project_ley_length <= 16);
        CheckInput::checkInput($project_key_validation, "projectKey must contain 16-byte key");

        $this->AESKEY = array_slice($this->project_key, 0, 16, false);
        $this->HmacSHA1Key = array_slice($this->project_key, 16, $project_ley_length - 16, false);


        $buffer = [];

        $long1 = ArrayOptions::createLong(16);
        $lengthLong = ArrayOptions::createLong($project_ley_length - 16);

        foreach ($long1 as $item) {
            $buffer[] = chr($item);
        }
        ArrayOptions::copyToBuffer($buffer, $this->AESKEY);

        foreach ($lengthLong as $item) {
            $buffer[] = chr($item);
        }
        ArrayOptions::copyToBuffer($buffer, $this->HmacSHA1Key);

        $data = implode("", $buffer);

        $digest = openssl_digest($data, 'SHA1', true);

        $this->key_digest_check = ArrayOptions::arrayCopy($digest, 0, 3);
        $this->HmacSHA1Key = implode("", $this->HmacSHA1Key);
        $this->AESKEY = implode("", $this->AESKEY);

    }

    /**
     * @throws \Exception
     *
     * @return String
     */
    public function prepareKey() {
        $keyDecoded = base64_decode($this->key);
        $valid = strlen($keyDecoded) > 17; // check if the encrypted string is valid
        $typeCheck = ord($keyDecoded[0]); // check the type of key

        if ($valid === true) {
            if ($typeCheck === 0) {
                if (strcmp(ArrayOptions::arrayCopy($keyDecoded, 1, 4), $this->key_digest_check) === 0) { // project signature check
                    $hmacKeyCheck = ArrayOptions::arrayCopy($this->HmacSHA1Key, 0, 3);
                    $keyLast4 = ArrayOptions::arrayCopy($keyDecoded, strlen($keyDecoded) - 4, strlen($keyDecoded) - 1);
                    if (strcmp($hmacKeyCheck, $keyLast4) !== 0) { // hmac signature check
                        //iv prepare
                        $ivParameterSpec = ArrayOptions::arrayCopy($keyDecoded, 5, 5 + 7);
                        $ivParameterSpec = ArrayOptions::checkIv(ArrayOptions::convert($ivParameterSpec, true));
                        $ivParameterSpec = ArrayOptions::convert($ivParameterSpec, false);

                        //key to be encoded
                        $toBeEncoded = ArrayOptions::arrayCopy($keyDecoded, 13, strlen($keyDecoded) - 5);
                        $toBeEncoded = ArrayOptions::checkIv(ArrayOptions::convert($toBeEncoded, true));
                        $toBeEncoded = ArrayOptions::convert($toBeEncoded, false);
                        $enc = openssl_encrypt($toBeEncoded, 'AES-128-CTR', $this->AESKEY, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $ivParameterSpec);

                        $encArray = ArrayOptions::convert($enc, true);
                        $encData = ArrayOptions::copyArray($encArray, strlen($keyDecoded) - 17);
                        //return the encrypted data as key
                        return base64_encode(ArrayOptions::convert($encData, false));

                    } else {
                        throw new \Exception("HMAC signature does not match.");
                    }
                } else {
                    throw new \Exception("Project key signature does not match.");
                }
            } else {
                throw new \Exception("Bad 'type' in encoded string.");
            }
        } else {
            throw new \Exception("Encrypted string is invalid.");
        }
    }
}
