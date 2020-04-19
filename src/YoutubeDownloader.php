<?php

namespace YoutubeDownloader;

use YoutubeDownloader\Device\DeviceModel;
use YoutubeDownloader\Device\UserAgents;
use YoutubeDownloader\Models\SignParams;
use YoutubeDownloader\Request\DeviceRegistrationRequest;
use YoutubeDownloader\Request\PlayerRequest;
use YoutubeDownloader\Response\DeviceRegistrationResponse;
use YoutubeDownloader\Utils\DeviceRegistrationHelper;
use YoutubeDownloader\Utils\PlayerRequestBuildUrl;

/**
 * Class YoutubeDownloader
 * @package YoutubeDownloader
 */
class YoutubeDownloader {

    /**
     * @var array
     */
    protected $loginOptions = ['id' => '', 'key' => ''];

    /**
     * @var $deviceRegistrationHelper DeviceRegistrationHelper|null
     */
    protected $deviceRegistrationHelper = null;

    /**
     * @var $encryptionKey string
     */
    protected $encryptionKey;

    /**
     * @var DeviceRegistrationRequest
     */
    protected $deviceRegistrationRequest;

    /**
     * @var $requestClient Request
     */
    protected $requestClient;

    /**
     * @var $playerRequest PlayerRequest
     */
    public $playerRequest;

    /**
     * YoutubeDownloader constructor.
     */
    public function __construct() {
        $this->requestClient = new Request();
        $this->deviceRegistrationRequest = new DeviceRegistrationRequest($this->requestClient);
        $this->playerRequest = new PlayerRequest($this->requestClient);
        $this->requestClient->setUserAgent(UserAgents::getRandomDevice());
        $this->requestClient->addHeader("User-Agent", UserAgents::build_from_model($this->requestClient->getUserAgent()));

    }

    /**
     * @return Device\DeviceModel
     */
    public function getUserAgent(){
        return $this->requestClient->getUserAgent();
    }

    /**
     * @param $user_agent DeviceModel
     */
    public function setUserAgent($user_agent){
        $this->requestClient->setUserAgent($user_agent);
        $this->requestClient->addHeader("User-Agent", UserAgents::build_from_model($this->requestClient->getUserAgent()));

    }

    /**
     * @param $id string
     * @param $key string
     *
     * @throws \Exception
     */
    public function registerIdKey($id, $key) {
        $this->loginOptions = ['id' => $id, "key" => $key];
        $this->deviceRegistrationHelper = new DeviceRegistrationHelper($id, $key);
        $this->encryptionKey = $this->deviceRegistrationHelper->prepareKey();
        $this->requestClient->setSignParams(SignParams::getInstance($this->loginOptions['id'], base64_decode($this->encryptionKey)));
        $this->prepareHeaders();
    }

    /**
     *
     */
    private function prepareHeaders() {
        $this->requestClient
            ->addHeader("Content-Type", 'application/x-protobuf')
            ->addHeader("X-GOOG-API-FORMAT-VERSION", "2")
            ->addHeader("Accept-Encoding", "gzip, deflate");
    }

    /**
     * If you havent the id&key then
     * you can register one hier
     *
     * @return DeviceRegistrationResponse
     *
     * @throws \Exception
     */
    public function registerDevice() {
        $response = $this->deviceRegistrationRequest->deviceregistration();
        $this->registerIdKey($response->getId(), $response->getKey());
        return $response;
    }
}
