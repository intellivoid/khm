<?php

    namespace khm\Objects;

    use khm\Abstracts\HostFlags;

    class QueryResults
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
         * Information about the IP addresses onion relay if available, otherwise null.
         *
         * @var OnionRelay|null
         */
        public $Onion;

        /**
         * Information about the IP addresses geolocation if available, otherwise null.
         *
         * @var GeoLookup|null
         */
        public $Geo;

        /**
         * Information about the abuse status of the IP address
         *
         * @var AbuseCheck|null
         */
        public $Abuse;

        /**
         * Flags associated with this IP address query
         *
         * @var string[]|HostFlags[]
         */
        public $Flags;
    }