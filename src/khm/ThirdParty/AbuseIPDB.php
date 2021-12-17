<?php

    namespace khm\ThirdParty;

    use CurlFile;
    use InvalidArgumentException;
    use khm\Classes\Curl;
    use khm\Objects\AbuseCheck;
    use RuntimeException;

    class AbuseIPDB
    {
        /**
         * Sends generic API request
         *
         * @param string $path
         * @param string $api_key
         * @param string $method
         * @param array $data
         * @return string
         */
        private static function apiRequest(string $path, string $api_key, string $method, array $data): string
        {
            $curlErrorNumber = -1;                   // will be used later to check curl execution
            $curlErrorMessage = '';
            $url = 'https://api.abuseipdb.com/api/v2/' . $path;  // api url

            // set the wanted format, JSON (required to prevent having full html page on error)
            // and the AbuseIPDB API Key as a header
            $headers = [
                'Accept: application/json;',
                'Key: ' . $api_key,
            ];

            // open curl connection
            $ch = curl_init();


            // set the method and data to send
            if ($method == 'POST')
            {
                Curl::setCurlOption($ch, CURLOPT_POST, true);
                Curl::setCurlOption($ch, CURLOPT_POSTFIELDS, $data);

            }
            else
            {
                Curl::setCurlOption($ch, CURLOPT_CUSTOMREQUEST, $method);
                $url .= '?' . http_build_query($data);
            }

            // set url and options
            Curl::setCurlOption($ch, CURLOPT_URL, $url);
            Curl::setCurlOption($ch, CURLOPT_RETURNTRANSFER, 1);
            Curl::setCurlOption($ch, CURLOPT_HTTPHEADER, $headers);

            /**
             * set timeout
             *
             * @see https://curl.se/libcurl/c/CURLOPT_TIMEOUT_MS.html
             * @see https://curl.se/libcurl/c/CURLOPT_CONNECTTIMEOUT_MS.html
             *  If libcurl is built to use the standard system name resolver, that portion of the transfer
             *  will still use full-second resolution for timeouts with a minimum timeout allowed of one second.
             *  In unix-like systems, this might cause signals to be used unless CURLOPT_NOSIGNAL is set.
             */
            Curl::setCurlOption($ch, CURLOPT_NOSIGNAL, 1);
            //$this->setCurlOption($ch, CURLOPT_TIMEOUT_MS, $this->timeout);

            // execute curl call
            $result = curl_exec($ch);
            $curlErrorNumber = curl_errno($ch);
            $curlErrorMessage = curl_error($ch);

            // close connection
            curl_close($ch);

            if ($curlErrorNumber !== 0)
                throw new RuntimeException($curlErrorMessage);

            return $result;
        }

        /**
         * Does a lookup against AbuseIP's Database
         *
         * @param string $api_key
         * @param string $ip
         * @param int $maxAgeInDays
         * @param bool $verbose
         * @return AbuseCheck
         */
        public static function check(string $api_key, string $ip, int $maxAgeInDays = 30, bool $verbose = false): AbuseCheck
        {
            // max age must be less or equal to 365
            if ( $maxAgeInDays > 365 || $maxAgeInDays < 1 ){
                throw new InvalidArgumentException('maxAgeInDays must be between 1 and 365.');
            }

            // ip must be set
            if (empty($ip)){
                throw new InvalidArgumentException('ip argument must be set (empty value given)');
            }

            // minimal data
            $data = [
                'ipAddress'     => $ip,
                'maxAgeInDays'  => $maxAgeInDays,
            ];

            // option
            if ($verbose){
                $data['verbose'] = true;
            }

            return AbuseCheck::fromArray(json_decode(self::apiRequest('check', $api_key, 'GET', $data), true));
        }
    }