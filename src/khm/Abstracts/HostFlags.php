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
    }