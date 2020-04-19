<?php

namespace YoutubeDownloader;

use YoutubeDownloader\Constants\Constants;
use YoutubeDownloader\Device\DeviceModel;
use YoutubeDownloader\Models\SignParams;
use YoutubeDownloader\Response\DeviceRegistrationResponse;

/**
 * Class Request
 * @package YoutubeDownloader
 */
class Request {

    /**
     * @var \GuzzleHttp\Client
     */
    protected $guzzleClient;

    /**
     * @var $proxy string
     */
    protected $proxy = null;

    /**
     * @var $urlParams array
     */
    protected $urlParams;

    /**
     * @var $bodyParams array
     */
    protected $bodyParams;

    /**
     * @var $headers array
     */
    protected $headers;

    /**
     * @var $isBodyInBytes bool
     */
    protected $isBodyInBytes;

    /**
     * @var $multibyteBody string
     */
    protected $multibyteBody;

    /**
     * @var $path string
     */
    protected $path;

    /**
     * @var $signParams SignParams
     */
    protected $signParams;

    /**
     * @var $user_agent DeviceModel
     */
    public $user_agent;

    /**
     * Request constructor.
     */
    public function __construct() {
        $this->guzzleClient = new \GuzzleHttp\Client(
            [
                'exceptions' => false,
                'verify' => false
            ]
        );

    }

    /**
     * @param $user_agent
     */
    public function setUserAgent($user_agent) {
        $this->user_agent = $user_agent;
    }

    /**
     * @return DeviceModel
     */
    public function getUserAgent() {
        return $this->user_agent;
    }

    /**
     * @return SignParams
     */
    public function getSignParams() {
        return $this->signParams;
    }

    /**
     * @param SignParams $signKey
     */
    public function setSignParams($signKey) {
        $this->signParams = $signKey;
    }

    /**
     * @param $body
     * @return $this
     */
    public function addBodyMultibyte($body) {
        $this->isBodyInBytes = true;
        $this->multibyteBody = $body;

        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function addUrlParam($name, $value) {
        $this->urlParams[$name] = $value;
        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function addBodyParam($name, $value) {
        $this->bodyParams[$name] = $value;
        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function addHeader($name, $value) {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * @param $method
     * @param $url
     * @param $body
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function request($method, $url, $body) {

        $options = [
            'headers' => $this->headers,
            'body' => $body
        ];
        if ($this->proxy !== null) {
            $options['proxy'] = $this->proxy;
        }
        $this->cleanUp();
        return $this->guzzleClient->request($method, $url, $options);
    }

    private function cleanUp() {
        $this->urlParams = [];
        $this->bodyParams = [];
    }

    /**
     * @param $path
     * @return $this
     */
    public function _req($path) {
        $this->path = $path;
        return $this;
    }

    public function get() {
        $url = Constants::YOUTUBE_API_URL . $this->path . $this->buildParams($this->urlParams);
        if ($this->isBodyInBytes === true) {
            $body = $this->multibyteBody;
            $this->addHeader("Content-Type", 'application/x-protobuf');
        } else {
            $this->addHeader("Content-Type", 'application/x-www-form-urlencoded; charset=UTF-8');
            $body = $this->buildParams($this->bodyParams);
        }
        $this->request("GET", $url, $body);
    }


    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function post() {
        $url = Constants::YOUTUBE_API_URL . $this->path . $this->buildParams($this->urlParams);
        if ($this->isBodyInBytes === true) {
            $body = $this->multibyteBody;
            $this->addHeader("Content-Type", 'application/x-protobuf');
        } else {
            $this->addHeader("Content-Type", 'application/x-www-form-urlencoded; charset=UTF-8');
            $body = $this->buildParams($this->bodyParams);
        }
        return $this->request("POST", $url, $body);
    }

    /**
     * @param $arrayParams
     * @return bool|null|string
     */
    private function buildParams($arrayParams) {
        if (is_array($arrayParams) === false || $arrayParams === null) {
            return null;
        }
        $urlParams = '';
        foreach ($arrayParams as $paramName => $paramValue) {
            $urlParams .= $paramName . '=' . $paramValue . '&';
        }
        return substr($urlParams, 0, -1);
    }


}
