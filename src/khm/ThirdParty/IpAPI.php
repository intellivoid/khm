<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace khm\ThirdParty;

    use Exception;
    use khm\Objects\GeoLookup;
    use WpOrg\Requests\Requests;

    class IpAPI
    {
        /**
         * Fields to request for each IPs.
         *
         * @var array
         */
        private $fields;

        /**
         * The language setting for the query.
         *
         * @var string
         */
        private $lang;

        /**
         * The TTL header.
         *
         * @var int
         */
        private $X_TTL;

        /**
         * The rate limit header.
         *
         * @var int
         */
        private $X_RL;

        /**
         * The query limit per request.
         */
        private static $limit = 100;

        /**
         * The API endpoint.
         *
         * @var string
         */
        private static $endpoint = 'http://ip-api.com/batch';

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
         * Set the fields to request.
         *
         * @param array $fields
         * @return IpAPI
         */
        public function setFields(array $fields): IpAPI
        {
            $this->fields = $fields;

            return $this;
        }

        /**
         * Append a request field.
         *
         * @param string $field
         * @return IpAPI
         */
        public function addField(string $field): IpAPI
        {
            $this->fields[] = $field;

            return $this;
        }

        /**
         * Get the fields to be requested.
         *
         * @return array
         */
        public function getFields(): array
        {
            return $this->fields;
        }

        /**
         * Get the fields to be requested, as a string.
         *
         * @return string
         */
        public function getFieldString(): string
        {
            return join(',', $this->fields);
        }

        /**
         * Set the language for this query.
         *
         * @param string $lang
         */
        public function setLanguage($lang): IpAPI
        {
            $this->lang = $lang;

            return $this;
        }

        /**
         * Get the language setting for this query.
         *
         * @return string
         */
        public function getLanguage(): string
        {
            return $this->lang;
        }

        /**
         * Submit a request and decode the response.
         *
         * @param  string|array $query
         * @return GeoLookup
         * @throws Exception
         */
        public function get(string $query): GeoLookup
        {
            $payload = $this->buildPayload($query);
            return $this->wait()->request($payload);
        }

        /**
         * Submit a request and decode the response.
         *
         * @param  string|array $query
         * @return GeoLookup[]
         * @throws Exception
         */
        public function get_batch(array $query): array
        {
            $payload = $this->buildPayload($query);
            return $this->wait()->request_batch($payload);
        }

        /**
         * Build the payload data for this request. Each IP address submitted must
         * individually contain the desired fields and language.
         *
         * @param string|array $query
         * @return array
         * @throws Exception
         */
        private function buildPayload($query): array
        {
            $payload = [];

            foreach ((array) $query as $ip) {
                $i = ['query' => $ip];
                if ($this->fields) $i['fields'] = $this->getFieldString();
                if ($this->lang) $i['lang'] = $this->lang;

                $payload[] = $i;
            }

            if (count($payload) > static::$limit) {
                throw new Exception("Can't request over " . static::$limit . " items.");
            }

            return $payload;
        }

        /**
         * Wait until it's safe to make requests.
         *
         * @return self
         */
        private function wait(): IpAPI
        {
            if ($this->X_RL === 0) {
                sleep($this->X_TTL + 1);
            }

            return $this;
        }

        /**
         * Submit a request to the server.
         *
         * @param array $payload
         * @return GeoLookup
         * @throws Exception
         */
        private function request(array $payload): GeoLookup
        {
            $response = Requests::post(
                static::$endpoint,
                static::$headers,
                json_encode($payload)
            );

            if ($response->status_code >= 400)
                throw new Exception("API response status: " . $response->status_code);

            $this->X_TTL = (int) $response->headers['x-ttl'];
            $this->X_RL = (int) $response->headers['x-rl'];

            return GeoLookup::fromArray(json_decode($response->body, true)[0], 'ip-api.com');
        }

        /**
         * Submit a request to the server.
         *
         * @param array $payload
         * @return array
         * @throws Exception
         */
        private function request_batch(array $payload): array
        {
            $response = Requests::post(
                static::$endpoint,
                static::$headers,
                json_encode($payload)
            );

            if ($response->status_code >= 400)
                throw new Exception("API response status: " . $response->status_code);

            $this->X_TTL = (int) $response->headers['x-ttl'];
            $this->X_RL = (int) $response->headers['x-rl'];

            $results = [];
            foreach(json_decode($response->body, true) as $item)
                $results[] = GeoLookup::fromArray($item, 'ip-api.com');
            return $results;
        }
    }