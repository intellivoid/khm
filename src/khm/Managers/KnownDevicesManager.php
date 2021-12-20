<?php

    namespace khm\Managers;

    use khm\Classes\Utilities;
    use khm\Exceptions\DatabaseException;
    use khm\Exceptions\KnownDeviceNotFoundException;
    use khm\khm;
    use khm\Objects\Device;
    use khm\Objects\KnownDevice;
    use khm\Objects\KnownHost;
    use msqg\QueryBuilder;
    use ZiProto\ZiProto;

    class KnownDevicesManager
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
         * Registers a new record into the database
         *
         * @param Device $device
         * @param KnownHost $knownHost
         * @return KnownDevice
         * @throws DatabaseException
         * @noinspection PhpCastIsUnnecessaryInspection
         */
        public function registerRecord(Device $device, KnownHost $knownHost): KnownDevice
        {
            $knownDevice = new KnownDevice();
            $knownDevice->ID = Utilities::generateKnownDeviceId($knownHost, $device);
            $knownDevice->CreatedTimestamp = time();
            $knownDevice->LastSeenTimestamp = time();
            $knownDevice->IPAddress = $knownHost->IPAddress;
            $knownDevice->DeviceFingerprint = $device->Fingerprint;

            $Query = QueryBuilder::insert_into('known_devices', [
                'id' => $this->khm->getDatabase()->real_escape_string($knownDevice->ID),
                'ip_address' => $this->khm->getDatabase()->real_escape_string($knownDevice->IPAddress),
                'device_fingerprint' => $this->khm->getDatabase()->real_escape_string($knownDevice->DeviceFingerprint),
                'properties' => $this->khm->getDatabase()->real_escape_string(ZiProto::encode($knownDevice->Properties->toArray())),
                'last_seen_timestamp' => (int)$knownDevice->LastSeenTimestamp,
                'created_timestamp' => (int)$knownDevice->CreatedTimestamp
            ]);

            $QueryResults = $this->khm->getDatabase()->query($Query);

            if($QueryResults == false)
            {
                throw new DatabaseException($Query, $this->khm->getDatabase()->error);
            }

            return $knownDevice;
        }

        /**
         * Returns an existing known device record from the database
         *
         * @param string $id
         * @return KnownDevice
         * @throws DatabaseException
         * @throws KnownDeviceNotFoundException
         */
        public function getRecord(string $id): KnownDevice
        {
            $Query = QueryBuilder::select('known_devices', [
                'id',
                'ip_address',
                'device_fingerprint',
                'properties',
                'last_seen_timestamp',
                'created_timestamp'
            ], 'id', $this->khm->getDatabase()->real_escape_string($id));

            $QueryResults = $this->khm->getDatabase()->query($Query);

            if($QueryResults == false)
            {
                throw new DatabaseException($Query, $this->khm->getDatabase()->error);
            }

            $Row = $QueryResults->fetch_array(MYSQLI_ASSOC);

            if ($Row == False)
            {
                throw new KnownDeviceNotFoundException('The known device id \'' . $id . '\' was not found');
            }

            $Row['properties'] = ZiProto::decode($Row['properties']);

            return KnownDevice::fromArray($Row);
        }

        /**
         * Updates the properties of an existing record
         *
         * @param KnownDevice $device
         * @return void
         * @throws DatabaseException
         */
        public function updateProperties(KnownDevice $device)
        {
            $Query = QueryBuilder::update('known_devices', [
                'properties' => $this->khm->getDatabase()->real_escape_string(ZiProto::encode($device->Properties->toArray()))
            ], 'id', $this->khm->getDatabase()->real_escape_string($device->ID));

            $QueryResults = $this->khm->getDatabase()->query($Query);

            if($QueryResults == false)
            {
                throw new DatabaseException($Query, $this->khm->getDatabase()->error);
            }
        }

        /**
         * Updates the last seen of a known device record
         *
         * @param KnownDevice $device
         * @return KnownDevice
         * @throws DatabaseException
         */
        public function updateLastSeen(KnownDevice $device): KnownDevice
        {
            $device->LastSeenTimestamp = time();
            $Query = QueryBuilder::update('known_devices', [
                'last_seen_timestamp' => $device->LastSeenTimestamp
            ], 'id', $this->khm->getDatabase()->real_escape_string($device->ID));

            $QueryResults = $this->khm->getDatabase()->query($Query);

            if($QueryResults == false)
            {
                throw new DatabaseException($Query, $this->khm->getDatabase()->error);
            }

            return $device;
        }
    }