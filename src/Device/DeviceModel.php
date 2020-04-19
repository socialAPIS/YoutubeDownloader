<?php

namespace YoutubeDownloader\Device;

class DeviceModel {

    public $androidVersion;
    public $manufacturer;
    public $model;
    public $locale;
    public $buildVersion;

    /**
     * DeviceModel constructor.
     * @param $androidVersion
     * @param $manufacturer
     * @param $model
     * @param $locale
     * @param $buildVersion
     */
    public function __construct($androidVersion = null, $manufacturer = null, $model = null, $locale = null, $buildVersion = null) {
        $this->androidVersion = $androidVersion;
        $this->manufacturer = $manufacturer;
        $this->model = $model;
        $this->locale = $locale;
        $this->buildVersion = $buildVersion;
    }


    /**
     * @return mixed
     */
    public function getAndroidVersion() {
        return $this->androidVersion;
    }

    /**
     * @return null
     */
    public function getLocale() {
        return $this->locale;
    }

    /**
     * @param null $locale
     */
    public function setLocale($locale) {
        $this->locale = $locale;
    }

    /**
     * @param mixed $androidVersion
     */
    public function setAndroidVersion($androidVersion) {
        $this->androidVersion = $androidVersion;
    }

    /**
     * @return mixed
     */
    public function getManufacturer() {
        return $this->manufacturer;
    }

    /**
     * @param mixed $manufacturer
     */
    public function setManufacturer($manufacturer) {
        $this->manufacturer = $manufacturer;
    }

    /**
     * @return mixed
     */
    public function getModel() {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model) {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getBuildVersion() {
        return $this->buildVersion;
    }

    /**
     * @param mixed $buildVersion
     */
    public function setBuildVersion($buildVersion) {
        $this->buildVersion = $buildVersion;
    }

    public function toArray() {
        return json_decode(json_encode($this), true);
    }

}
