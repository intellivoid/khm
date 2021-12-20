<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace khm\Objects;

    use khm\Objects\Device\Properties;

    class Device
    {
        /**
         * The unique fingerprint for the device
         *
         * @var string
         */
        public $Fingerprint;

        /**
         * The raw user agent string returned by the client
         *
         * @var string
         */
        public $UserAgent;

        /**
         * The detected operating system family
         *
         * @var string|null
         */
        public $OperatingSystemFamily;

        /**
         * The detected operating system version
         *
         * @var string|null
         */
        public $OperatingSystemVersion;

        /**
         * The detected device family
         *
         * @var string|null
         */
        public $DeviceFamily;

        /**
         * The detected device brand
         *
         * @var string|null
         */
        public $DeviceBrand;

        /**
         * The detected device model
         *
         * @var string|null
         */
        public $DeviceModel;

        /**
         * The detected version of the browser family
         *
         * @var string|null
         */
        public $BrowserFamily;

        /**
         * The detected version of the browser
         *
         * @var string|null
         */
        public $BrowserVersion;

        /**
         * Indicates if the browser is a mobile browser
         *
         * @var bool
         */
        public $MobileBrowser;

        /**
         * Indicates if the device is a mobile device
         *
         * @var bool
         */
        public $MobileDevice;

        /**
         * Properties associated with this device
         *
         * @var Properties
         */
        public $Properties;

        /**
         * The Unix Timestamp for when this device was last seen
         *
         * @var int
         */
        public $LastSeenTimestamp;

        /**
         * The Unix Timestamp for when this record was first created
         *
         * @var int
         */
        public $CreatedTimestamp;

        public function __construct()
        {
            $this->Properties = new Properties();
            $this->MobileDevice = false;
            $this->MobileBrowser = false;
        }

        /**
         * Returns an array representation of the object
         *
         * @return array
         */
        public function toArray(): array
        {
            return [
                'fingerprint' => $this->Fingerprint,
                'user_agent' => $this->UserAgent,
                'os_family' => $this->OperatingSystemFamily,
                'os_version' => $this->OperatingSystemVersion,
                'device_family' => $this->DeviceFamily,
                'device_brand' => $this->DeviceBrand,
                'device_model' => $this->DeviceModel,
                'browser_family' => $this->BrowserFamily,
                'browser_version' => $this->BrowserVersion,
                'mobile_browser' => $this->MobileBrowser,
                'mobile_device' => $this->MobileDevice,
                'properties' => $this->Properties->toArray(),
                'last_seen_timestamp' => $this->LastSeenTimestamp,
                'created_timestamp' => $this->CreatedTimestamp
            ];
        }

        /**
         * Constructs object from an array representation
         *
         * @param array $data
         * @return Device
         */
        public static function fromArray(array $data): Device
        {
            $DeviceObject = new Device();

            if(isset($data['fingerprint']))
                $DeviceObject->Fingerprint = $data['fingerprint'];

            if(isset($data['user_agent']))
                $DeviceObject->UserAgent = $data['user_agent'];

            if(isset($data['os_family']))
                $DeviceObject->OperatingSystemFamily = $data['os_version'];

            if(isset($data['os_version']))
                $DeviceObject->OperatingSystemVersion = $data['os_version'];

            if(isset($data['device_family']))
                $DeviceObject->DeviceFamily = $data['device_family'];

            if(isset($data['device_brand']))
                $DeviceObject->DeviceBrand = $data['device_brand'];

            if(isset($data['device_model']))
                $DeviceObject->DeviceModel = $data['device_model'];

            if(isset($data['browser_family']))
                $DeviceObject->BrowserFamily = $data['browser_family'];

            if(isset($data['browser_version']))
                $DeviceObject->BrowserVersion = $data['browser_version'];

            if(isset($data['mobile_browser']))
                $DeviceObject->MobileBrowser = $data['mobile_browser'];

            if(isset($data['mobile_device']))
                $DeviceObject->MobileDevice = $data['mobile_device'];

            if(isset($data['properties']))
                $DeviceObject->Properties = Properties::fromArray($data['properties']);

            if(isset($data['last_seen_timestamp']))
                $DeviceObject->LastSeenTimestamp = (int)$data['last_seen_timestamp'];

            if(isset($data['created_timestamp']))
                $DeviceObject->CreatedTimestamp = (int)$data['created_timestamp'];

            return $DeviceObject;
        }
    }