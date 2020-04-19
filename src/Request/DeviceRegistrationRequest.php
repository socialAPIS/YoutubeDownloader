<?php

namespace YoutubeDownloader\Request;

use YoutubeDownloader\Constants\Constants;
use YoutubeDownloader\Response\DeviceRegistrationResponse;
use YoutubeDownloader\Traits\RandomStringGenerator;
use YoutubeDownloader\Traits\RequestClientTrait;

/**
 * Class DeviceRegistrationRequest
 * @package YoutubeDownloader\Request
 */
class DeviceRegistrationRequest {
    use RandomStringGenerator;
    use RequestClientTrait;


    /**
     * @return DeviceRegistrationResponse
     *
     * @throws \Exception
     */
    public function deviceregistration() {
        $response = $this->client->_req("/deviceregistration/v1/devices?")
            ->addUrlParam("key", Constants::YOUTUBE_API_KEY)
            ->addUrlParam("rawDeviceId", $this->random_str(16))
            ->post();

        if ($response->getStatusCode() === 200) {
            $responseArray = json_decode($response->getBody()->getContents(), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return DeviceRegistrationResponse::getInstance($responseArray['id'], $responseArray['key']);
            }
            throw new \Exception("Device registration failed, error message: " . json_last_error_msg());
        } else {
            throw new \Exception("Device registration failed with status code " . $response->getStatusCode());
        }

    }
}
