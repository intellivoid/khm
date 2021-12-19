<?php

    namespace khm\Managers;

    use khm\Exceptions\DatabaseException;
    use khm\Exceptions\KnownHostRecordNotFoundException;
    use khm\khm;
    use khm\Objects\KnownHost;
    use msqg\QueryBuilder;
    use ZiProto\ZiProto;

    class KnownHostsManager
    {
        /**
         * @var khm
         */
        private $khm;

        /**
         * @param khm $khm
         */
        public function __construct(khm $khm)
        {
            $this->khm = $khm;
        }

        /**
         * Registers a new known record into the database
         *
         * @param KnownHost $knownHost
         * @return KnownHost
         * @throws DatabaseException
         * @noinspection PhpCastIsUnnecessaryInspection
         */
        public function registerRecord(KnownHost $knownHost): KnownHost
        {
            $knownHost->CreatedTimestamp = time();
            $knownHost->LastSeenTimestamp = time();

            $Query = QueryBuilder::insert_into('known_hosts', [
                'ip_address' => $this->khm->getDatabase()->real_escape_string($knownHost->IPAddress),
                'properties' => $this->khm->getDatabase()->real_escape_string(ZiProto::encode($knownHost->Properties)),
                'last_seen_timestamp' => (int)$knownHost->LastSeenTimestamp,
                'created_timestamp' => (int)$knownHost->CreatedTimestamp
            ]);

            $QueryResults = $this->khm->getDatabase()->query($Query);

            if($QueryResults == false)
            {
                throw new DatabaseException($Query, $this->khm->getDatabase()->error);
            }

            return $knownHost;
        }

        /**
         * Returns an existing record from the database
         *
         * @param string $ip_address
         * @return KnownHost
         * @throws DatabaseException
         * @throws KnownHostRecordNotFoundException
         */
        public function getRecord(string $ip_address): KnownHost
        {
            $Query = QueryBuilder::select('known_hosts', [
                'ip_address',
                'properties',
                'last_seen_timestamp',
                'created_timestamp'
            ], 'ip_address', $this->khm->getDatabase()->real_escape_string($ip_address));

            $QueryResults = $this->khm->getDatabase()->query($Query);

            if($QueryResults == false)
            {
                throw new DatabaseException($Query, $this->khm->getDatabase()->error);
            }

            $Row = $QueryResults->fetch_array(MYSQLI_ASSOC);

            if ($Row == False)
            {
                throw new KnownHostRecordNotFoundException('The known host \'' . $ip_address . '\' was not found');
            }

            $Row['properties'] = ZiProto::decode($Row['properties']);

            return KnownHost::fromArray($Row);
        }

        /**
         * Updates the properties of a known host
         *
         * @param KnownHost $knownHost
         * @return void
         * @throws DatabaseException
         */
        public function updateProperties(KnownHost $knownHost)
        {
            $Query = QueryBuilder::update('known_hosts', [
                'properties' => $this->khm->getDatabase()->real_escape_string(ZiProto::encode($knownHost->Properties->toArray()))
            ], 'ip_address', $this->khm->getDatabase()->real_escape_string($knownHost->IPAddress));


            $QueryResults = $this->khm->getDatabase()->query($Query);

            if($QueryResults == false)
            {
                throw new DatabaseException($Query, $this->khm->getDatabase()->error);
            }
        }

        /**
         * Updates the last seen of a known hsost
         *
         * @param KnownHost $knownHost
         * @return KnownHost
         * @throws DatabaseException
         */
        public function updateLastSeen(KnownHost $knownHost): KnownHost
        {
            $knownHost->LastSeenTimestamp = time();
            $Query = QueryBuilder::update('known_hosts', [
                'last_seen_timestamp' => $knownHost->LastSeenTimestamp
            ], 'ip_address', $this->khm->getDatabase()->real_escape_string($knownHost->IPAddress));


            $QueryResults = $this->khm->getDatabase()->query($Query);

            if($QueryResults == false)
            {
                throw new DatabaseException($Query, $this->khm->getDatabase()->error);
            }

            return $knownHost;
        }
    }