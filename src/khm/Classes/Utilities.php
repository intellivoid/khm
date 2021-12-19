<?php

    namespace khm\Classes;

    use khm\Objects\Device;
    use khm\Objects\KnownHost;

    class Utilities
    {
        /**
         * @param KnownHost $knownHost
         * @param Device $device
         * @return string
         */
        public static function generateKnownDeviceId(KnownHost $knownHost, Device $device): string
        {
            return hash('sha1', $knownHost->IPAddress . $device->Fingerprint);
        }
    }