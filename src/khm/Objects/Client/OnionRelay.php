<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace khm\Objects\Client;

    use khm\Abstracts\OnionVersionStatus;

    class OnionRelay
    {
        /**
         * Relay nickname consisting of 1–19 alphanumerical characters.
         *
         * @var string
         */
        public $Nickname;

        /**
         * Relay fingerprint consisting of 40 upper-case hexadecimal characters.
         *
         * @var string
         */
        public $Fingerprint;

        /**
         * Array of IPv4 or IPv6 addresses and TCP ports or port lists where the relay accepts onion-routing connections.
         * The first address is the primary onion-routing address that the relay used to register in the network,
         * subsequent addresses are in arbitrary order. IPv6 hex characters are all lower-case.
         *
         * @var string[]
         */
        public $OrAddresses;

        /**
         * Array of IPv4 addresses that the relay used to exit to the Internet in the past 24 hours.
         * Omitted if array is empty.
         *
         * @var string[]
         */
        public $ExitAddresses;

        /**
         * IPv4 address where the relay accepts directory connections.
         * Omitted if the relay does not accept directory connections.
         *
         * @var string|null
         */
        public $DirAddress;

        /**
         * TCP port where the relay accepts directory connections.
         * Omitted if the relay does not accept directory connections.
         *
         * @var int|null
         */
        public $DirPort;

        /**
         * Unix Timestamp for when this relay was last seen in a network status consensus.
         *
         * @var int
         */
        public $LastSeenTimestamp;

        /**
         * Unix Timestamp for when this relay last stopped announcing an IPv4 or IPv6 address or TCP port where it
         * previously accepted onion-routing or directory connections. This timestamp can serve as indicator whether
         * this relay would be a suitable fallback directory.
         *
         * @var int
         */
        public $LastChangedAddressOrPort;

        /**
         * Unix Timestamp for when this relay was first seen in a network status consensus.
         *
         * @var int
         */
        public $FirstSeen;

        /**
         * Array of relay flags that the directory authorities assigned to this relay. May be omitted if empty.
         *
         * @var array
         */
        public $Flags;

        /**
         * Boolean field saying whether this relay was listed as running in the last relay network status consensus.
         *
         * @var bool
         */
        public $Running;

        /**
         * Indicates if the exit flag is present
         *
         * @var bool
         */
        public $Exit;

        /**
         * Indicates if the fast flag is present
         *
         * @var bool
         */
        public $Fast;

        /**
         * Indicates if the guard flag is present
         *
         * @var bool
         */
        public $Guard;

        /**
         * Indicates if the stable flag is present
         *
         * @var bool
         */
        public $Stable;

        /**
         * Indicates if the valid flag is present
         *
         * @var bool
         */
        public $Valid;

        /**
         * Contact address of the relay operator. Omitted if empty or if descriptor containing this information
         * cannot be found.
         *
         * @var string|null
         */
        public $Contact;

        /**
         * Platform string containing operating system and Tor version details. Omitted if empty or if descriptor
         * containing this information cannot be found.
         *
         * @var string|null
         */
        public $Platform;

        /**
         * Tor software version without leading "Tor" as reported by the directory authorities in the "v" line of the
         * consensus. Omitted if either the directory authorities or the relay did not report which version the
         * relay runs or if the relay runs an alternative Tor implementation.
         *
         * @var string|null
         */
        public $Version;

        /**
         * Status of the Tor software version of this relay based on the versions recommended by the directory
         * authorities. Possible version statuses are: "recommended" if a version is listed as recommended;
         * "experimental" if a version is newer than every recommended version; "obsolete" if a version is older
         * than every recommended version; "new in series" if a version has other recommended versions with the
         * same first three components, and the version is newer than all such recommended versions, but it is not
         * newer than every recommended version; "unrecommended" if none of the above conditions hold. Omitted if
         * either the directory authorities did not recommend versions, or the relay did not report which version it runs.
         *
         * @var string|OnionVersionStatus|null
         */
        public $VersionStatus;

        /**
         * Weight assigned to this relay by the directory authorities that clients use in their path selection
         * algorithm. The unit is arbitrary; currently it's kilobytes per second, but that might change in the future.
         *
         * @var int
         */
        public $ConsensusWeight;

        /**
         * The Unix Timestamp for when this record was last updated
         *
         * @var int
         */
        public $LastUpdatedTimestmap;

        /**
         * The Unix Timestamp for when this record was first registered into the database
         *
         * @var int
         */
        public $CreatedTimestmap;

        /**
         * Returns an array representation of the object
         *
         * @return array
         * @noinspection PhpCastIsUnnecessaryInspection
         */
        public function toArray(): array
        {
            return [
                'nickname' => $this->Nickname,
                'fingerprint' => $this->Fingerprint,
                'or_addresses' => $this->OrAddresses,
                'exit_addresses' => $this->ExitAddresses,
                'dir_address' => $this->DirAddress,
                'dir_port' => (int)$this->DirPort,
                'last_seen_timestamp' => (int)$this->LastSeenTimestamp,
                'last_changed_address_or_port' => (int)$this->LastChangedAddressOrPort,
                'first_seen' => (int)$this->FirstSeen,
                'flags' => $this->Flags,
                'running' => (bool)$this->Running,
                'exit' => (bool)$this->Exit,
                'fast' => (bool)$this->Fast,
                'guard' => (bool)$this->Guard,
                'stable' => (bool)$this->Stable,
                'valid' => (bool)$this->Valid,
                'contact' => $this->Contact,
                'platform' => $this->Platform,
                'version' => $this->Version,
                'version_status' => $this->VersionStatus,
                'consensus_weight' => (int)$this->ConsensusWeight,
                'last_updated_timestamp' => (int)$this->LastUpdatedTimestmap,
                'created_timestamp' => (int)$this->CreatedTimestmap
            ];
        }

        /**
         * Constructs object from an array representation
         *
         * @param array $data
         * @return OnionRelay
         */
        public static function fromArray(array $data): OnionRelay
        {
            $OnionRelayObject = new OnionRelay();

            if(isset($data['nickname']))
                $OnionRelayObject->Nickname = $data['nickname'];

            if(isset($data['fingerprint']))
                $OnionRelayObject->Fingerprint = $data['fingerprint'];

            if(isset($data['or_addresses']))
                $OnionRelayObject->OrAddresses = $data['or_addresses'];

            if(isset($data['exit_addresses']))
                $OnionRelayObject->ExitAddresses = $data['exit_addresses'];

            if(isset($data['dir_address']))
                $OnionRelayObject->DirAddress = $data['dir_address'];

            if(isset($data['dir_port']))
                $OnionRelayObject->DirPort = (int)$data['dir_port'];

            if(isset($data['last_seen_timestamp']))
                $OnionRelayObject->LastSeenTimestamp = (int)$data['last_seen_timestamp'];

            if(isset($data['last_changed_address_or_port']))
                $OnionRelayObject->LastChangedAddressOrPort = (int)$data['last_changed_address_or_port'];

            if(isset($data['first_seen']))
                $OnionRelayObject->FirstSeen = (int)$data['first_seen'];

            if(isset($data['flags']))
                $OnionRelayObject->Flags = $data['flags'];

            if(isset($data['running']))
                $OnionRelayObject->Running = (bool)$data['running'];

            if(isset($data['exit']))
                $OnionRelayObject->Exit = (bool)$data['exit'];

            if(isset($data['fast']))
                $OnionRelayObject->Fast = (bool)$data['fast'];

            if(isset($data['guard']))
                $OnionRelayObject->Guard = (bool)$data['guard'];

            if(isset($data['stable']))
                $OnionRelayObject->Stable = (bool)$data['stable'];

            if(isset($data['valid']))
                $OnionRelayObject->Valid = (bool)$data['valid'];

            if(isset($data['contact']))
                $OnionRelayObject->Contact = $data['contact'];

            if(isset($data['platform']))
                $OnionRelayObject->Platform = $data['platform'];

            if(isset($data['version']))
                $OnionRelayObject->Version = $data['version'];

            if(isset($data['version_status']))
                $OnionRelayObject->VersionStatus = $data['version_status'];

            if(isset($data['consensus_weight']))
                $OnionRelayObject->ConsensusWeight = $data['consensus_weight'];

            if(isset($data['last_updated_timestamp']))
                $OnionRelayObject->LastUpdatedTimestmap = (int)$data['last_updated_timestamp'];

            if(isset($data['created_timestamp']))
                $OnionRelayObject->CreatedTimestmap = (int)$data['created_timestamp'];

            return $OnionRelayObject;
        }

        /**
         * Constructs object from a onion relay record
         *
         * @param \khm\Objects\OnionRelay $relay
         * @return OnionRelay
         */
        public static function fromOnionRelayObject(\khm\Objects\OnionRelay $relay): OnionRelay
        {
            return self::fromArray($relay->toArray());
        }
    }