<?php

    namespace khm\Abstracts;

    abstract class HostFlags
    {
        /**
         * Indicates that this IP address has a history of reported
         */
        const BadUser = 'BAD_USER';

        /**
         * Indicates that the IP address is a part of the Tor network acting as a relay
         */
        const TorRelay = 'TOR_RELAY';

        /**
         * Indicates that the IP address is an exit node
         */
        const TorExit = 'TOR_EXIT';

        /**
         * Indicates that the device is a mobile device
         */
        const MobileDevice = 'MOBILE_DEVICE';

        /**
         * Indicates that the browser is a mobile browser
         */
        const MobileBrowser = 'MOBILE_BROWSER';
    }