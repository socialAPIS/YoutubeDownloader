<?php

namespace YoutubeDownloader\Response;

/**
 * Class DeviceRegistrationResponse
 * @package YoutubeDownloader\Response
 */
class DeviceRegistrationResponse {

    /**
     * @var $id string
     */
    protected $id;

    /**
     * @var $key string
     */
    protected $key;

    /**
     * DeviceRegistrationResponse constructor.
     * @param $id string
     * @param $key string
     */
    public function __construct($id, $key) {
        $this->id = $id;
        $this->key = $key;
    }

    public static function getInstance($id, $key) {
        return new self($id, $key);
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
    public function getKey() {
        return $this->key;
    }

    /**
     * @return array
     */
    public function toArray() {
        return ['id' => $this->id, "key" => $this->key];
    }

}
