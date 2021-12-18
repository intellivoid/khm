<?php

    namespace khm\Managers;

    use khm\Exceptions\DatabaseException;
    use khm\Exceptions\OnionRecordNotFoundException;
    use khm\khm;
    use khm\Objects\OnionRelay;
    use msqg\QueryBuilder;
    use ZiProto\ZiProto;

    class OnionManager
    {
        private khm $khm;

        /**
         * @param khm $khm
         */
        public function __construct(khm $khm)
        {
            $this->khm = $khm;
        }

        /**
         * Registers an onion relay record into the database
         *
         * @param OnionRelay $relay
         * @return OnionRelay
         * @throws DatabaseException
         * @noinspection PhpCastIsUnnecessaryInspection
         */
        public function registerRecord(OnionRelay $relay): OnionRelay
        {
            $relay->LastUpdatedTimestmap = time();
            $relay->CreatedTimestmap = time();

            $Query = QueryBuilder::insert_into('onion', [
                'ip_address' => $this->khm->getDatabase()->real_escape_string($relay->IPAddress),
                'ip_version' => (int)$relay->IPVersion,
                'nickname' => $this->khm->getDatabase()->real_escape_string($relay->Nickname),
                'fingerprint' => $this->khm->getDatabase()->real_escape_string($relay->Fingerprint),
                'or_addresses' => $this->khm->getDatabase()->real_escape_string(ZiProto::encode($relay->OrAddresses)),
                'exit_addresses' => ($relay->ExitAddresses == null ?  $this->khm->getDatabase()->real_escape_string(ZiProto::encode([])) : $this->khm->getDatabase()->real_escape_string(ZiProto::encode($relay->ExitAddresses))),
                'dir_address' => ($relay->DirAddress == null ? null : $this->khm->getDatabase()->real_escape_string($relay->DirAddress)),
                'dir_port' => ($relay->DirPort == null ? null : (int)$this->khm->getDatabase()->real_escape_string($relay->DirPort)),
                'last_seen_timestamp' => (int)$relay->LastSeenTimestamp,
                'last_changed_address_or_port' => (int)$relay->LastChangedAddressOrPort,
                'first_seen' => (int)$relay->FirstSeen,
                'flags' => ($relay->Flags == null ? $this->khm->getDatabase()->real_escape_string(ZiProto::encode([])) : $this->khm->getDatabase()->real_escape_string(ZiProto::encode($relay->Flags))),
                'running' => (int)$relay->Running,
                '`exit`' => (int)$relay->Exit,
                'fast' => (int)$relay->Fast,
                'guard' => (int)$relay->Guard,
                'stable' => (int)$relay->Stable,
                'valid' => (int)$relay->Valid,
                'contact' => ($relay->Contact == null ? null : $this->khm->getDatabase()->real_escape_string($relay->Contact)),
                'platform' => ($relay->Platform == null ? null : $this->khm->getDatabase()->real_escape_string($relay->Platform)),
                'version' => ($relay->Version == null ? null : $this->khm->getDatabase()->real_escape_string($relay->Version)),
                'version_status' => ($relay->VersionStatus == null ? null : $this->khm->getDatabase()->real_escape_string($relay->VersionStatus)),
                'consensus_weight' => ($relay->ConsensusWeight == null ? null : (int)$relay->ConsensusWeight),
                'last_updated_timestamp' => (int)$relay->LastUpdatedTimestmap,
                'created_timestamp' => (int)$relay->CreatedTimestmap
            ]);

            $QueryResults = $this->khm->getDatabase()->query($Query);

            if($QueryResults == false)
            {
                throw new DatabaseException($Query, $this->khm->getDatabase()->error);
            }

            return $relay;
        }

        /**
         * Returns an existing record from the database
         *
         * @param string $ip_address
         * @return OnionRelay
         * @throws DatabaseException
         * @throws OnionRecordNotFoundException
         */
        public function getRecord(string $ip_address): OnionRelay
        {
            $Query = QueryBuilder::select('onion', [
                'ip_address',
                'ip_version',
                'nickname',
                'fingerprint',
                'or_addresses',
                'exit_addresses',
                'dir_address',
                'dir_port',
                'last_seen_timestamp',
                'last_changed_address_or_port',
                'first_seen',
                'flags',
                'running',
                '`exit`',
                'fast',
                'guard',
                'stable',
                'valid',
                'contact',
                'platform',
                'version',
                'version_status',
                'consensus_weight',
                'last_updated_timestamp',
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
                throw new OnionRecordNotFoundException('The onion record for the IP \'' . $ip_address . '\' was not found');
            }

            return OnionRelay::fromArray($Row);
        }

        /**
         * Updates an existing record from the database
         *
         * @param OnionRelay $relay
         * @return OnionRelay
         * @throws DatabaseException
         * @noinspection PhpCastIsUnnecessaryInspection
         */
        public function updateRecord(OnionRelay $relay): OnionRelay
        {
            $relay->LastUpdatedTimestmap = time();

            $Query = QueryBuilder::update('onion', [
                'nickname' => $this->khm->getDatabase()->real_escape_string($relay->Nickname),
                'fingerprint' => $this->khm->getDatabase()->real_escape_string($relay->Fingerprint),
                'or_addresses' => $this->khm->getDatabase()->real_escape_string(ZiProto::encode($relay->OrAddresses)),
                'exit_addresses' => ($relay->ExitAddresses == null ?  $this->khm->getDatabase()->real_escape_string(ZiProto::encode([])) : $this->khm->getDatabase()->real_escape_string(ZiProto::encode($relay->ExitAddresses))),
                'dir_address' => ($relay->DirAddress == null ? null : $this->khm->getDatabase()->real_escape_string($relay->DirAddress)),
                'dir_port' => ($relay->DirPort == null ? null : (int)$this->khm->getDatabase()->real_escape_string($relay->DirPort)),
                'last_seen_timestamp' => (int)$relay->LastSeenTimestamp,
                'last_changed_address_or_port' => (int)$relay->LastChangedAddressOrPort,
                'first_seen' => (int)$relay->FirstSeen,
                'flags' => ($relay->Flags == null ? $this->khm->getDatabase()->real_escape_string(ZiProto::encode([])) : $this->khm->getDatabase()->real_escape_string(ZiProto::encode($relay->Flags))),
                'running' => (int)$relay->Running,
                '`exit`' => (int)$relay->Exit,
                'fast' => (int)$relay->Fast,
                'guard' => (int)$relay->Guard,
                'stable' => (int)$relay->Stable,
                'valid' => (int)$relay->Valid,
                'contact' => ($relay->Contact == null ? null : $this->khm->getDatabase()->real_escape_string($relay->Contact)),
                'platform' => ($relay->Platform == null ? null : $this->khm->getDatabase()->real_escape_string($relay->Platform)),
                'version' => ($relay->Version == null ? null : $this->khm->getDatabase()->real_escape_string($relay->Version)),
                'version_status' => ($relay->VersionStatus == null ? null : $this->khm->getDatabase()->real_escape_string($relay->VersionStatus)),
                'consensus_weight' => ($relay->ConsensusWeight == null ? null : (int)$relay->ConsensusWeight),
                'last_updated_timestamp' => (int)$relay->LastUpdatedTimestmap,
            ], 'ip_address', $this->khm->getDatabase()->real_escape_string($relay->IPAddress));


            $QueryResults = $this->khm->getDatabase()->query($Query);

            if($QueryResults == false)
            {
                throw new DatabaseException($Query, $this->khm->getDatabase()->error);
            }

            return $relay;
        }
    }