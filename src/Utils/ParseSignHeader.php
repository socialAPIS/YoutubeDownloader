<?php

namespace YoutubeDownloader\Utils;

class ParseSignHeader {

    private static function base64TrimEnd($input) {
        return str_replace("=", '', $input);
    }

    public static function parse($id, $content, $data) {
        $format = 'device_id=%s,data=%s,content=%s';

        return sprintf($format, $id, self::base64TrimEnd($data), self::base64TrimEnd($content));
    }
}
