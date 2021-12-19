<?php

    namespace khm\Objects;

    use khm\Objects\KnownHost\Properties;

    class KnownHost
    {
        /**
         * The IP address of the known host
         *
         * @var string
         */
        public $IPAddress;

        /**
         * Properties associated with this known host
         *
         * @var Properties
         */
        public $Properties;

        /**
         * The Unix Timestamp for when this host was last seen
         *
         * @var int
         */
        public $LastSeenTimestamp;

        /**
         * The Unix Timestamp for when this known host was first registered into the database
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
                'ip_address' => $this->IPAddress,
                'properties' => $this->Properties->toArray(),
                'last_seen_timestamp' => $this->LastSeenTimestamp,
                'created_timestamp' => $this->CreatedTimestamp
            ];
        }

        /**
         * Constructs object from an array representation
         *
         * @param array $data
         * @return KnownHost
         */
        public static function fromArray(array $data): KnownHost
        {
            $KnownHostObject = new KnownHost();

            if(isset($data['ip_address']))
                $KnownHostObject->IPAddress = $data['ip_address'];

            if(isset($data['properties']))
                $KnownHostObject->Properties = Properties::fromArray($data['properties']);

            if(isset($data['last_seen_timestamp']))
                $KnownHostObject->LastSeenTimestamp = (int)$data['last_seen_timestamp'];

            if(isset($data['created_timestamp']))
                $KnownHostObject->CreatedTimestamp = (int)$data['created_timestamp'];

            return $KnownHostObject;
        }
    }