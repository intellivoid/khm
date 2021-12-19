<?php

    namespace khm\Managers;

    use khm\Abstracts\SearchMethods\DeviceSearchMethod;
    use khm\Exceptions\DatabaseException;
    use khm\Exceptions\DeviceRecordNotFoundException;
    use khm\Exceptions\InvalidSearchMethodException;
    use khm\khm;
    use khm\Objects\Device;
    use msqg\QueryBuilder;
    use ZiProto\ZiProto;

    class DevicesManager
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
         * @return Device
         * @throws DatabaseException
         * @noinspection PhpCastIsUnnecessaryInspection
         */
        public function registerRecord(Device $device): Device
        {
            $device->LastSeenTimestamp = time();
            $device->CreatedTimestamp = time();
            if($device->Properties == null)
                $device->Properties = new Device\Properties();

            $Query = QueryBuilder::insert_into('devices', [
                'fingerprint' => $this->khm->getDatabase()->real_escape_string($device->Fingerprint),
                'user_agent' => $this->khm->getDatabase()->real_escape_string($device->UserAgent),
                'os_family' => ($device->OperatingSystemFamily == null ? null : $this->khm->getDatabase()->real_escape_string($device->OperatingSystemFamily)),
                'os_version' => ($device->OperatingSystemVersion == null ? null : $this->khm->getDatabase()->real_escape_string($device->OperatingSystemVersion)),
                'device_family' => ($device->DeviceFamily == null ? null : $this->khm->getDatabase()->real_escape_string($device->DeviceFamily)),
                'device_brand' => ($device->DeviceBrand == null ? null : $this->khm->getDatabase()->real_escape_string($device->DeviceBrand)),
                'device_model' => ($device->DeviceModel == null ? null : $this->khm->getDatabase()->real_escape_string($device->DeviceModel)),
                'browser_family' => ($device->BrowserFamily == null ? null : $this->khm->getDatabase()->real_escape_string($device->BrowserFamily)),
                'browser_version' => ($device->BrowserVersion == null ? null : $this->khm->getDatabase()->real_escape_string($device->BrowserVersion)),
                'mobile_browser' => ($device->MobileBrowser == null ? null : $this->khm->getDatabase()->real_escape_string($device->MobileBrowser)),
                'mobile_device' => ($device->MobileDevice == null ? null : $this->khm->getDatabase()->real_escape_string($device->MobileDevice)),
                'properties' => $this->khm->getDatabase()->real_escape_string(ZiProto::encode($device->Properties->toArray())),
                'last_seen_timestamp' => (int)$device->LastSeenTimestamp,
                'created_timestamp' => (int)$device->CreatedTimestamp
            ]);

            $QueryResults = $this->khm->getDatabase()->query($Query);

            if($QueryResults == false)
            {
                throw new DatabaseException($Query, $this->khm->getDatabase()->error);
            }

            return $device;
        }

        /**
         * Returns an existing record from the database
         *
         * @throws InvalidSearchMethodException
         * @throws DeviceRecordNotFoundException
         * @throws DatabaseException
         */
        public function getRecord(string $search_method, string $value): Device
        {
            switch($search_method)
            {
                case DeviceSearchMethod::ByFingerprint:
                case DeviceSearchMethod::ByUserAgent:
                    $search_method = $this->khm->getDatabase()->real_escape_string($search_method);
                    $value = $this->khm->getDatabase()->real_escape_string($value);
                    break;

                default:
                    throw new InvalidSearchMethodException('The given search method \'' . $search_method . '\' is not affected');
            }

            $Query = QueryBuilder::select('devices', [
                'fingerprint',
                'user_agent',
                'os_family',
                'device_family',
                'device_brand',
                'device_model',
                'browser_family',
                'browser_version',
                'mobile_browser',
                'mobile_device',
                'properties',
                'last_seen_timestamp',
                'created_timestamp'
            ], $search_method, $value);

            $QueryResults = $this->khm->getDatabase()->query($Query);

            if($QueryResults == false)
            {
                throw new DatabaseException($Query, $this->khm->getDatabase()->error);
            }

            $Row = $QueryResults->fetch_array(MYSQLI_ASSOC);

            if ($Row == False)
            {
                throw new DeviceRecordNotFoundException('The device record was not found');
            }

            $Row['properties'] = ZiProto::decode($Row['properties']);

            return Device::fromArray($Row);
        }

        /**
         * Updates the properties of a device
         *
         * @param Device $device
         * @return void
         * @throws DatabaseException
         */
        public function updateDeviceProperties(Device $device)
        {
            $Query = QueryBuilder::update('devices', [
                'properties' => $this->khm->getDatabase()->real_escape_string(ZiProto::encode($device->Properties->toArray()))
            ], 'fingerprint', $this->khm->getDatabase()->real_escape_string($device->Fingerprint));


            $QueryResults = $this->khm->getDatabase()->query($Query);

            if($QueryResults == false)
            {
                throw new DatabaseException($Query, $this->khm->getDatabase()->error);
            }
        }

        /**
         * Updates the last seen of a device
         *
         * @param Device $device
         * @return void
         * @throws DatabaseException
         */
        public function updateLastSeen(Device $device): Device
        {
            $device->LastSeenTimestamp = time();
            $Query = QueryBuilder::update('devices', [
                'last_seen_timestamp' => $device->LastSeenTimestamp
            ], 'fingerprint', $this->khm->getDatabase()->real_escape_string($device->Fingerprint));


            $QueryResults = $this->khm->getDatabase()->query($Query);

            if($QueryResults == false)
            {
                throw new DatabaseException($Query, $this->khm->getDatabase()->error);
            }

            return $device;
        }
    }