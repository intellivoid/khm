<?php

    namespace khm\Objects;

    use khm\Abstracts\HostFlags;
    use khm\Objects\Client\Abuse;
    use khm\Objects\Client\Geo;

    class Client
    {
        /**
         * The queried IP address
         *
         * @var string
         */
        public $IPAddress;

        /**
         * The version of the IP address
         *
         * @var int
         */
        public $IPVersion;

        /**
         * The ID of the known device if available
         *
         * @var string|null
         */
        public $KnownDeviceID;

        /**
         * Information about the IP addresses onion relay if available, otherwise null.
         *
         * @var \khm\Objects\Client\OnionRelay|null
         */
        public $Onion;

        /**
         * Information about the IP addresses geolocation if available, otherwise null.
         *
         * @var Geo|null
         */
        public $Geo;

        /**
         * Information about the abuse status of the IP address
         *
         * @var Abuse|null
         */
        public $Abuse;

        /**
         * Information about the users' device if available
         *
         * @var Device|null
         */
        public $Device;

        /**
         * Flags associated with this IP address query
         *
         * @var string[]|HostFlags[]
         */
        public $Flags;

        /**
         * Returns an array representation of the object
         *
         * @return array
         */
        public function toArray(): array
        {
            return [
                'ip_address' => $this->IPAddress,
                'ip_version' => $this->IPVersion,
                'known_device_id' => $this->KnownDeviceID,
                'onion' => ($this->Onion == null ? null : $this->Onion->toArray()),
                'geo' => ($this->Geo == null ? null : $this->Geo->toArray()),
                'abuse' => ($this->Abuse == null ? null : $this->Abuse->toArray()),
                'device' => ($this->Device == null ? null : $this->Device->toArray()),
                'flags' => ($this->Flags == null ? [] : $this->Flags),
            ];
        }
    }