<?php

namespace YoutubeDownloader\Request;

use YoutubeDownloader\Constants\Constants;
use YoutubeDownloader\Request\Model\PlayerRequestModel;
use YoutubeDownloader\Traits\Base64EncodeUrl;
use YoutubeDownloader\Traits\RequestClientTrait;
use YoutubeDownloader\Traits\SignData;
use YoutubeDownloader\Utils\ParseProtobufResponse;
use YoutubeDownloader\Utils\ParseSignHeader;
use YoutubeDownloader\Utils\RequestBuildUrl;
use YoutubeDownloader\Utils\SHA1PRNG;

/**
 * Class PlayerRequest
 * @package YoutubeDownloader\Request
 */
class PlayerRequest {
    use RequestClientTrait;
    use Base64EncodeUrl;
    use SignData;

    /**
     * @param $video_id string
     *
     * @return \player_response
     *
     * @throws \Exception
     */
    public function fetch_player_info($video_id) {
        $SHA1PRNG_Random = new SHA1PRNG();
        $random = $SHA1PRNG_Random->nextBytes();
        $t = $this->base64url_encode($random);

        $playerRequest = new PlayerRequestModel();

        $playerRequest->setManufacturer($this->client->getUserAgent()->getManufacturer());
        $playerRequest->setModel($this->client->getUserAgent()->getModel());
        $playerRequest->setVideoId($video_id);
        $plre = BuildProtobufFromJSON::build($playerRequest, \player_request::class);
        $body = $plre->serializeToString();

        $data = $this->sign(RequestBuildUrl::buildUrl($video_id, $t), $this->client->getSignParams()->getSignedKey(), 4);
        $content = $this->sign($body, $this->client->getSignParams()->getSignedKey(), 20);

        $this->client->addHeader('X-Goog-Device-Auth', ParseSignHeader::parse($this->client->getSignParams()->getId(), $content, $data));

        $response = $this->client->_req("/youtubei/v1/player?")
            ->addUrlParam('key', Constants::YOUTUBE_API_KEY)
            ->addUrlParam("id", $video_id)
            ->addUrlParam('t', $t)
            ->addBodyMultibyte($body)
            ->post();

        return ParseProtobufResponse::parse($response, \player_response::class);

    }
}
