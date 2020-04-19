<?php

namespace YoutubeDownloader\Models;

/**
 * Class SignParams
 * @package YoutubeDownloader\Models
 */
class SignParams {

    /**
     * @var $id string
     */
    protected $id;

    /**
     * @var $signed_key string
     */
    protected $signed_key;

    /**
     * SignParams constructor.
     * @param string $id
     * @param string $signed_key
     */
    public function __construct($id, $signed_key) {
        $this->id = $id;
        $this->signed_key = $signed_key;
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSignedKey() {
        return $this->signed_key;
    }

    public static function getInstance($id, $signed_key) {
        return new self($id, $signed_key);
    }

}
