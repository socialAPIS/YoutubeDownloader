<?php

namespace YoutubeDownloader\Request;

class BuildProtobufFromJSON {

    /**
     * @param $json_model
     * @param $protobuf_class \Google\Protobuf\Internal\Message
     *
     * @return mixed
     */
    public static function build($json_model, $protobuf_class) {
        $class = new $protobuf_class();
        $class->parseFromJsonStream($json_model);
        return $class;
    }
}
