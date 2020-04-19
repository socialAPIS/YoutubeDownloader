<?php

namespace YoutubeDownloader\Traits;

use YoutubeDownloader\Request;

trait RequestClientTrait {

    /**
     * @var $request Request
     */
    public $client;

    /**
     * RequestClientTrait constructor.
     * @param $request
     */
    public function __construct($request) {
        $this->client = $request;
    }


}
