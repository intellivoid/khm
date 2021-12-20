<?php

    namespace khm\Classes\UserAgentParser;

    use khm\Abstracts\AbstractParser;
    use khm\Classes\RegexLoader;
    use khm\Classes\UserAgentParser;
    use khm\Objects\UserAgentClient;

    class Parser extends AbstractParser
    {
        /**
         * @var DeviceParser
         */
        private $deviceParser;

        /**
         * @var OperatingSystemParser
         */
        private $operatingSystemParser;

        /**
         * @var UserAgentParser
         */
        private $userAgentParser;

        /**
         * Start up the parser by importing the data file to $this->regexes
         */
        public function __construct()
        {
            parent::__construct(RegexLoader::getRegex());
            $this->deviceParser = new DeviceParser($this->regexes);
            $this->operatingSystemParser = new OperatingSystemParser($this->regexes);
            $this->userAgentParser = new UserAgentParser($this->regexes);
        }

        /**
         * Sets up some standard variables as well as starts the user agent parsing process
         *
         * @param string $userAgent
         * @param array $jsParseBits
         * @return UserAgentClient
         */
        public function parse(string $userAgent, array $jsParseBits = []): UserAgentClient
        {
            $client = new UserAgentClient($userAgent);

            $client->ua = $this->userAgentParser->parseUserAgent($userAgent, $jsParseBits);
            $client->os = $this->operatingSystemParser->parseOperatingSystem($userAgent);
            $client->device = $this->deviceParser->parseDevice($userAgent);

            return $client;
        }
    }