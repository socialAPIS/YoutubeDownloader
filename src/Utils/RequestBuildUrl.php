<?php

namespace YoutubeDownloader\Utils;

use YoutubeDownloader\Constants\Constants;

/**
 * Class PlayerRequestBuildUrl
 * @package YoutubeDownloader\Utils
 */
class RequestBuildUrl {

    /**
     * @param $video_id string
     * @param $t string
     *
     * @return string
     *
     * @throws \Exception
     */
    public static function buildUrl($video_id, $t) {

        return Constants::YOUTUBE_API_URL .
            Constants::YOUTUBE_API_VER_URL .
            'player?key=' . Constants::YOUTUBE_API_KEY .
            "&id=$video_id&t=$t";
    }
}
