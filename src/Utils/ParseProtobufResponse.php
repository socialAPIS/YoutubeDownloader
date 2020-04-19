<?php

namespace YoutubeDownloader\Utils;

use Psr\Http\Message\ResponseInterface;

class ParseProtobufResponse {

    /**
     * @param $content ResponseInterface
     * @param $return_class string
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public static function parse($content, $return_class){
        if ($content->getStatusCode() === 200){
            $codedInputStream = new \Google\Protobuf\Internal\CodedInputStream($content->getBody()->getContents());
            $returnClass = new $return_class();
            $returnClass->parseFromStream($codedInputStream);
            return $returnClass;
        }
        throw new \Exception("Error parsing protobuf. Status code: " . $content->getStatusCode());


    }
}
