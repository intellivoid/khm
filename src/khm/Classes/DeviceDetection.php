<?php

    namespace khm\Classes;

    use khm\Classes\UserAgentParser\Parser;
    use khm\Exceptions\NoUserAgentProvidedException;
    use khm\Objects\Device;

    class DeviceDetection
    {
        /**
         * Detects the client's device if applicable
         *
         * @return Device
         * @throws NoUserAgentProvidedException
         */
        public static function detectDevice(): Device
        {
            if(isset($_SERVER['HTTP_USER_AGENT']) == false)
                throw new NoUserAgentProvidedException('Cannot detect the device because no user agent was provided');

            $parser = new Parser();
            $parsed_ua = $parser->parse($_SERVER['HTTP_USER_AGENT']);

            $MobileBrowserRegex = RegexLoader::getMobile1();
            $MobileDeviceRegex = RegexLoader::getMobile2();

            $Device = new Device();
            $Device->Fingerprint = hash('sha1', $_SERVER['HTTP_USER_AGENT']);
            $Device->UserAgent = $_SERVER['HTTP_USER_AGENT'];
            $Device->OperatingSystemFamily = ($parsed_ua->os->family == null ? null : $parsed_ua->os->family);
            $Device->OperatingSystemVersion = ($parsed_ua->os->toVersion() == null ? null : $parsed_ua->os->toVersion());
            $Device->DeviceFamily = ($parsed_ua->device->family == null ? null : $parsed_ua->device->family);
            $Device->DeviceBrand = ($parsed_ua->device->brand == null ? null : $parsed_ua->device->brand);
            $Device->DeviceModel = ($parsed_ua->device->model == null ? null : $parsed_ua->device->model);
            $Device->BrowserFamily = ($parsed_ua->ua->family == null ? null : $parsed_ua->ua->family);
            $Device->BrowserVersion = ($parsed_ua->ua->toVersion() == null ? null : $parsed_ua->ua->toVersion());
            $Device->MobileBrowser = (bool)preg_match($MobileBrowserRegex, $_SERVER['HTTP_USER_AGENT']);
            $Device->MobileDevice = (bool)preg_match($MobileDeviceRegex, $_SERVER['HTTP_USER_AGENT']);

            return $Device;
        }

        /**
         * Returns the IP address of the client
         *
         * @return string
         */
        public static function getClientIP(): string
        {
            if(isset($_SERVER['HTTP_CF_CONNECTING_IP']))
            {
                return $_SERVER['HTTP_CF_CONNECTING_IP'];
            }

            if(isset($_SERVER['HTTP_CLIENT_IP']))
            {
                return $_SERVER['HTTP_CLIENT_IP'];
            }

            if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }

            if(isset($_SERVER['HTTP_X_FORWARDED']))
            {
                return $_SERVER['HTTP_X_FORWARDED'];
            }

            if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            {
                return $_SERVER['HTTP_FORWARDED_FOR'];
            }

            if(isset($_SERVER['HTTP_FORWARDED']))
            {
                return $_SERVER['HTTP_FORWARDED'];
            }

            if(isset($_SERVER['REMOTE_ADDR']))
            {
                return $_SERVER['REMOTE_ADDR'];
            }

            if(getenv('HTTP_CLIENT_IP') !== False)
            {
                return getenv('HTTP_CLIENT_IP');
            }

            if(getenv('HTTP_X_FORWARDED_FOR'))
            {
                return getenv('HTTP_X_FORWARDED_FOR');
            }

            if(getenv('HTTP_X_FORWARDED'))
            {
                return getenv('HTTP_X_FORWARDED');
            }

            if(getenv('HTTP_FORWARDED_FOR'))
            {
                return getenv('HTTP_FORWARDED_FOR');
            }

            if(getenv('HTTP_FORWARDED'))
            {
                return getenv('HTTP_FORWARDED');
            }

            if(getenv('REMOTE_ADDR'))
            {
                return getenv('REMOTE_ADDR');
            }

            return '127.0.0.1';
        }

    }