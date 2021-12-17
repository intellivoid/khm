<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace khm\ThirdParty;

    use Exception;
    use khm\Objects\GeoLookup;
    use WpOrg\Requests\Requests;

    class IpAPIco
    {

        /**
         * The API endpoint.
         *
         * @var string
         */
        private static $endpoint = 'https://ipapi.co/';

        /**
         * The request headers.
         *
         * @var array
         */
        private static $headers = [
            'User-Agent: Intellivoid-KHM/1.0',
            'Content-Type: application/json',
            'Accept: application/json'
        ];


        /**
         * Submit a request to the server.
         *
         * @param string $ip_address
         * @return GeoLookup
         * @throws Exception
         */
        public function get(string $ip_address): GeoLookup
        {
            $response = Requests::get(
                static::$endpoint . urlencode($ip_address) . '/json',
                static::$headers
            );

            if ($response->status_code >= 400)
                throw new Exception("API response status: " . $response->status_code);

            return GeoLookup::fromArray(json_decode($response->body, true), 'ipapi.co');
        }

    }