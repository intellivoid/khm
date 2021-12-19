<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace khm;

    use acm2\acm2;
    use acm2\Exceptions\ConfigurationNotDefinedException;
    use acm2\Objects\Schema;
    use Exception;
    use khm\Abstracts\GeoLookupSource;
    use khm\Exceptions\AbuseRecordNotFoundException;
    use khm\Exceptions\BadGeoSourceException;
    use khm\Exceptions\GeoRecordNotFoundException;
    use khm\Managers\AbuseManager;
    use khm\Managers\DevicesManager;
    use khm\Managers\GeoManager;
    use khm\Managers\KnownDevicesManager;
    use khm\Managers\KnownHostsManager;
    use khm\Managers\OnionManager;
    use khm\Objects\AbuseCheck;
    use khm\Objects\GeoLookup;
    use khm\Objects\OnionRelay;
    use khm\ThirdParty\AbuseIPDB;
    use khm\ThirdParty\IpAPI;
    use khm\ThirdParty\IpAPIco;
    use khm\ThirdParty\TorProject;
    use mysqli;

    class khm
    {
        /**
         * @var acm2
         */
        private $acm;

        /**
         * @var mixed
         */
        private $DatabaseConfiguration;

        /**
         * @var mysqli|null
         */
        private $database;

        /**
         * @var int
         */
        private $LastConnectedDatabaseTimestamp;

        /**
         * @var AbuseManager
         */
        private $AbuseManager;

        /**
         * @var mixed
         */
        private $AbuseIpDbConfiguration;

        /**
         * @var GeoManager
         */
        private $GeoManager;

        /**
         * @var OnionManager
         */
        private $OnionManager;

        /**
         * @var DevicesManager
         */
        private $DevicesManager;

        /**
         * @var KnownHostsManager
         */
        private $KnownHostsManager;

        /**
         * @var KnownDevicesManager
         */
        private $KnownDevicesManager;

        /**
         * @throws ConfigurationNotDefinedException
         */
        public function __construct()
        {
            // Advanced Configuration Manager
            $this->acm = new acm2('khm');

            // Database Schema Configuration
            $DatabaseSchema = new Schema();
            $DatabaseSchema->setName('Database');
            $DatabaseSchema->setDefinition('Host', '127.0.0.1');
            $DatabaseSchema->setDefinition('Port', '3306');
            $DatabaseSchema->setDefinition('Username', 'root');
            $DatabaseSchema->setDefinition('Password', 'root');
            $DatabaseSchema->setDefinition('Name', 'khm');
            $this->acm->defineSchema($DatabaseSchema);

            // Database Schema Configuration
            $AbuseIpDB = new Schema();
            $AbuseIpDB->setName('AbuseIpDB');
            $AbuseIpDB->setDefinition('ApiKeys', []);
            $this->acm->defineSchema($AbuseIpDB);

            // Save any changes
            $this->acm->updateConfiguration();
            $this->acm->reloadConfiguration();

            // Get the configuration
            $this->DatabaseConfiguration = $this->acm->getConfiguration('Database');
            $this->AbuseIpDbConfiguration = $this->acm->getConfiguration('AbuseIpDB');

            $this->AbuseManager = new AbuseManager($this);
            $this->GeoManager = new GeoManager($this);
            $this->OnionManager = new OnionManager($this);
            $this->DevicesManager = new DevicesManager($this);
            $this->KnownHostsManager = new KnownHostsManager($this);
            $this->KnownDevicesManager = new KnownDevicesManager($this);
        }

        /**
         * @return mysqli|null
         */
        public function getDatabase(): ?mysqli
        {
            if($this->database == null)
            {
                $this->connectDatabase();
            }

            if( (time() - $this->LastConnectedDatabaseTimestamp) > 1800)
                $this->connectDatabase();

            return $this->database;
        }


        /**
         * Closes the current database connection
         */
        public function disconnectDatabase()
        {
            $this->database->close();
            $this->database = null;
            $this->LastConnectedDatabaseTimestamp = null;
        }

        /**
         * Creates a new database connection
         */
        public function connectDatabase()
        {
            if($this->database !== null)
            {
                $this->disconnectDatabase();
            }

            $this->database = new mysqli(
                $this->DatabaseConfiguration['Host'],
                $this->DatabaseConfiguration['Username'],
                $this->DatabaseConfiguration['Password'],
                $this->DatabaseConfiguration['Name'],
                $this->DatabaseConfiguration['Port']
            );
            $this->LastConnectedDatabaseTimestamp = time();
        }

        /**
         * Preforms an IP Abuse lookup, uses local database if the information is not out of date.
         *
         * @param string $ip_address
         * @return AbuseCheck
         * @throws Exceptions\DatabaseException
         */
        public function abuseLookup(string $ip_address): AbuseCheck
        {
            $selected_key = $this->AbuseIpDbConfiguration['ApiKeys'][array_rand($this->AbuseIpDbConfiguration['ApiKeys'])];

            try
            {
                $AbuseCheck = $this->AbuseManager->getRecord($ip_address);
            }
            catch(AbuseRecordNotFoundException $e)
            {
                $AbuseCheck = $this->AbuseManager->registerRecord(AbuseIPDB::check($selected_key, $ip_address));
            }

            if((time() - $AbuseCheck->LastUpdatedTimestamp) > 43200)
            {
                return $this->AbuseManager->updateRecord(AbuseIPDB::check($selected_key, $ip_address));
            }

            return $AbuseCheck;
        }

        /**
         * Preforms a Geo lookup query, or searches against the database if the record is not out of date
         *
         * @param string $ip_address
         * @param string $source
         * @return GeoLookup
         * @throws BadGeoSourceException
         * @throws Exceptions\DatabaseException
         * @throws Exception
         */
        public function geoLookup(string $ip_address, string $source=GeoLookupSource::ipApiCo): GeoLookup
        {
            try
            {
                $GeoLookup = $this->GeoManager->getRecord($ip_address);
            }
            catch(GeoRecordNotFoundException $e)
            {
                $GeoLookup = null;
            }

            if($GeoLookup == null || (time() - $GeoLookup->LastUpdatedTimestamp) >= 1209600)
            {
                switch($source)
                {
                    case GeoLookupSource::ipApi:
                        $api = new IpAPI();
                        $api->setLanguage('en');
                        $api->setFields([
                            'status', 'message', 'continent', 'continentCode', 'country', 'countryCode', 'region',
                            'regionName', 'city', 'district', 'zip', 'lat', 'lon', 'timezone', 'offset', 'currency',
                            'isp', 'org', 'as', 'asname', 'reverse', 'mobile', 'proxy', 'hosting', 'query'
                        ]);

                        if($GeoLookup == null)
                        {
                            $GeoLookup = $this->GeoManager->registerRecord($api->get($ip_address));
                        }
                        else
                        {
                            $GeoLookup = $this->GeoManager->updateRecord($api->get($ip_address));
                        }
                        break;

                    case GeoLookupSource::ipApiCo:
                        $api = new IpAPIco();

                        if($GeoLookup == null)
                        {
                            $GeoLookup = $this->GeoManager->registerRecord($api->get($ip_address));
                        }
                        else
                        {
                            $GeoLookup = $this->GeoManager->updateRecord($api->get($ip_address));
                        }

                        break;

                    default:
                        throw new BadGeoSourceException('The geo lookup source \'' . $source . '\' is not supported by the engine');
                }
            }

            return $GeoLookup;
        }

        /**
         * Preforms a batch query while comparing results from the database
         *
         * @param array $query
         * @return array
         * @throws Exceptions\DatabaseException
         * @throws Exception
         */
        public function multipleGeoLookup(array $query): array
        {
            $api = new IpAPI();
            $api->setLanguage('en');
            $api->setFields([
                'status', 'message', 'continent', 'continentCode', 'country', 'countryCode', 'region',
                'regionName', 'city', 'district', 'zip', 'lat', 'lon', 'timezone', 'offset', 'currency',
                'isp', 'org', 'as', 'asname', 'reverse', 'mobile', 'proxy', 'hosting', 'query'
            ]);

            $new_queries = [];
            $update_queries = [];
            $results = [];

            foreach($query as $item)
            {
                try
                {
                    $GeoLookup = $this->GeoManager->getRecord($item);
                    if((time() - $GeoLookup->LastUpdatedTimestamp) >= 1209600)
                    {
                        $update_queries[] = $item;
                    }
                    else
                    {
                        $results[] = $GeoLookup;
                    }
                }
                catch(GeoRecordNotFoundException $e)
                {
                    $new_queries[] = $item;
                }
            }

            foreach($api->getBatch(array_merge($new_queries, $update_queries)) as $lookup)
            {
                if(in_array($lookup->IPAddress, $update_queries))
                {
                    $results[] = $this->GeoManager->updateRecord($lookup);
                }

                if(in_array($lookup->IPAddress, $new_queries))
                {
                    $results[] = $this->GeoManager->registerRecord($lookup);
                }
            }

            return $results;
        }

        /**
         * Preforms a tor IP lookup against the database if the record exists
         *
         * @param string $ip_address
         * @return OnionRelay
         * @throws Exceptions\DatabaseException
         * @throws Exceptions\OnionRecordNotFoundException
         */
        public function torLookup(string $ip_address): OnionRelay
        {
            return $this->OnionManager->getRecord($ip_address);
        }

        /**
         * Syncs the current onion relays into the database
         *
         * @return void
         * @throws Exceptions\DatabaseException
         */
        public function syncOnionRelays()
        {
            $onion_relays = TorProject::getRelays();

            foreach($onion_relays as $relay)
            {
                try
                {
                    $this->OnionManager->getRecord($relay->IPAddress);
                    $this->OnionManager->updateRecord($relay);
                }
                catch (Exceptions\OnionRecordNotFoundException $e)
                {
                    $this->OnionManager->registerRecord($relay);
                }
            }
        }

        /**
         * @return DevicesManager
         */
        public function getDevicesManager(): DevicesManager
        {
            return $this->DevicesManager;
        }

        /**
         * @return KnownHostsManager
         */
        public function getKnownHostsManager(): KnownHostsManager
        {
            return $this->KnownHostsManager;
        }

        /**
         * @return KnownDevicesManager
         */
        public function getKnownDevicesManager(): KnownDevicesManager
        {
            return $this->KnownDevicesManager;
        }
    }