<?php

namespace YoutubeDownloader\Device;

class UserAgents {

    const DEVICES = [
        "Android 8.0.0; en_US; samsung; SM-G960F; Build/R16NW",
        "Android 7.0; en_US; samsung; SM-G892A; Build/NRD90M",
        "Android 7.0; en_US; samsung; SM-G930VC; Build/MMB29K",
        "Android 6.0.1; en_US; samsung; SM-G935S; Build/MMB29K",
        "Android 6.0.1; en_US; samsung; SM-G920V; Build/MMB29K",
        "Android 6.0.1; en_US; Nexus; 6P; Build/MMB29P",
        "Android 7.1.1; en_US; sony; G8231; Build/41.2.A.0.219",
        "Android 6.0; en_US; HTC; One X10; Build/MRA58K",
        "Android 6.0; en_US; HTC; One M9; Build/MRA58K"
    ];

    /**
     * @return DeviceModel
     */
    public static function getRandomDevice(){
        $randIndex = array_rand(self::DEVICES);
        $device_array = explode("; ", self::DEVICES[$randIndex]);

        return new DeviceModel($device_array[0], $device_array[2], $device_array[3], $device_array[1], $device_array[4]);
    }

    /**
     * @param $device_model DeviceModel
     *
     * @return string
     */
    public static function build_from_model($device_model){
        $format = 'com.google.android.youtube/14.43.55(Linux; U; %s; %s; %s %s %s) gzip';

        return sprintf($format, $device_model->getAndroidVersion(), $device_model->getLocale(), $device_model->getManufacturer(), $device_model->getModel(), $device_model->getBuildVersion());

    }
}
