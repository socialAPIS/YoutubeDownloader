<?php

require_once '../vendor/autoload.php';

$yt = new \YoutubeDownloader\YoutubeDownloader();

//If you save your id or key from last session
//you can use it hier

//$yt->registerIdKey("id", "key");

//device registration function
//you can grab from here the device id/key
//and save it somewhere for later use
$registrationResponse = $yt->registerDevice();

//if you want to save the user agent
//for next use you can do it by this
//$yt->getUserAgent()->toArray();

//here you need to initialize the DeviceModel
//and just pass it here
//$yt->setUserAgent($user_agent);

$playerResponse = $yt->playerRequest->fetch_player_info('6eqp7RMi04U'); // here we pass the video id

$echoString = "Video Id: " . $playerResponse->getVideoInfo()->getVideoId() . "\n";
$echoString .= "Video Tittle: " . $playerResponse->getVideoInfo()->getTittle() . "\n";
$echoString .= "Video duration: " . $playerResponse->getVideoInfo()->getDuration() . "\n";
$echoString .= "Uploaded on Channel: " . $playerResponse->getVideoInfo()->getChannel() . "\n";
$echoString .= "Video Description: " . $playerResponse->getVideoInfo()->getDescription() . "\n\n";

/**
 * @var $videos video[]
 */
$videos = $playerResponse->getPlayerVideos()->getVideos(); //it can happen that you have audio in video
/**
 * @var $audios audio[]
 */
$audios = $playerResponse->getPlayerVideos()->getAudios(); //it can happen that you have video in audio


$echoString .= "============== Videos ==============\n";
foreach ($videos as $video) {
    $echoString .= "Video URL: " . $video->getVideoUrl() . "\n";
    $echoString .= "Video format: " . $video->getFormat() . "\n";
    $echoString .= "Video Size Format: " . $video->getSizeFormat() . "\n";
    $echoString .= "Video Size: " . $video->getSize() . "\n\n";

}
$echoString .= "====================================\n\n";

$echoString .= "============== Audios ==============\n";
foreach ($audios as $video) {
    $echoString .= "Audio URL: " . $video->getAudioUrl() . "\n";
    $echoString .= "Audio format: " . $video->getFormat() . "\n";
    $echoString .= "Audio Size Format: " . $video->getSizeFormat() . "\n\n";

}
$echoString .= "====================================\n";

//comment this if you run this in a browser
echo $echoString;

//uncomment this if you run this in a browser
//echo str_replace("\n", "</br>", $echoString);