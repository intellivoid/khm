<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace khm\Objects;

    use khm\Objects\KnownDevice\Properties;

    class KnownDevice
    {
        /**
         * The unique ID of the known device
         *
         * @var string
         */
        public $ID;

        /**
         * The IP Address of the known device
         *
         * @var string
         */
        public $IPAddress;

        /**
         * The device fingerprint
         *
         * @var string
         */
        public $DeviceFingerprint;

        /**
         * Properties of this known host
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
         * The Unix Timestamp for when this device was first registered into the database
         *
         * @var int
         */
        public $CreatedTimestamp;

        public function __construct()
        {
            $this->Properties = new Properties();
        }

        /**
         * Returns an array representation of the object
         *
         * @return array
         */
        public function toArray(): array
        {
            return [
                'id' => $this->ID,
                'ip_address' => $this->IPAddress,
                'device_fingerprint' => $this->DeviceFingerprint,
                'properties' => $this->Properties->toArray(),
                'last_seen_timestamp' => $this->LastSeenTimestamp,
                'created_timestamp' => $this->CreatedTimestamp
            ];
        }

        /**
         * Constructs object from an array representation
         *
         * @param array $data
         * @return KnownDevice
         */
        public static function fromArray(array $data): KnownDevice
        {
            $KnownDeviceObject = new KnownDevice();

            if(isset($data['id']))
                $KnownDeviceObject->ID = $data['id'];

            if(isset($data['ip_address']))
                $KnownDeviceObject->IPAddress = $data['ip_address'];

            if(isset($data['device_fingerprint']))
                $KnownDeviceObject->DeviceFingerprint = $data['device_fingerprint'];

            if(isset($data['properties']))
                $KnownDeviceObject->Properties = Properties::fromArray($data['properties']);

            if(isset($data['last_seen_timestamp']))
                $KnownDeviceObject->LastSeenTimestamp = (int)$data['last_seen_timestamp'];

            if(isset($data['created_timestamp']))
                $KnownDeviceObject->CreatedTimestamp = (int)$data['created_timestamp'];

            return $KnownDeviceObject;
        }
    }