<?php

    namespace khm\Classes;

    use RuntimeException;

    class Curl
    {
        /**
         * Sends generic API request
         *
         * @param string $path
         * @param string $api_key
         * @param string $method
         * @param array $data
         * @return string
         * @noinspection DuplicatedCode
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
         * Sets a CURL Option, throws error if oopsie woopsie
         *
         * @param $ch
         * @param int $option
         * @param $value
         * @return void
         */
        public static function setCurlOption($ch, int $option, $value): void
        {
            if(!curl_setopt($ch,$option,$value))
            {
                throw new RuntimeException('curl_setopt failed! '.curl_error($ch));
            }
        }

    }