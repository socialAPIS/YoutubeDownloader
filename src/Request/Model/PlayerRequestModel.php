<?php

namespace YoutubeDownloader\Request\Model;

class PlayerRequestModel {

    public $jsonData = [
        "deviceData" => [
            "deviceInfo" => [
                "key1218e46a3dda39e239c59a80b5d0526508" => "",
                "key13189cc793e8d6be8b4bfce4ca55d8ae1d" => "",
                "key16eccbc87e4b5ce2fe28308fd9f2a7baf3" => 3,
                "key17d627cabbdf951974157c48b24fa9b779" => "14.43.55",
                "key1811534e01ccf9b2ac5f68d7f99b214c04" => "Android",
                "key227a20c4af648fdfb4a3e5fce3d812aab5" => "US",
                "key8020231c8e224de4d79e923e29e23eb3a0" => "America/Mexico_City"
            ]
        ],
        "videoId" => ""
    ];

    public function setManufacturer($manufacturer){
        $this->jsonData['deviceData']['deviceInfo']['key1218e46a3dda39e239c59a80b5d0526508'] = $manufacturer;
    }

    public function setModel($model){
        $this->jsonData['deviceData']['deviceInfo']['key13189cc793e8d6be8b4bfce4ca55d8ae1d'] = $model;
    }

    public function setVideoId($video_id){
        $this->jsonData["videoId"] = $video_id;
    }

    public function getData() {
        return json_encode($this->jsonData);
    }
}
