<?php

    namespace khm\Managers;

    use khm\Exceptions\DatabaseException;
    use khm\Exceptions\GeoRecordNotFoundException;
    use khm\khm;
    use khm\Objects\GeoLookup;
    use msqg\QueryBuilder;

    class GeoManager
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
         * Registers a geo lookup record into the database
         *
         * @param GeoLookup $geoLookup
         * @return GeoLookup
         * @throws DatabaseException
         * @noinspection PhpCastIsUnnecessaryInspection
         */
        public function registerRecord(GeoLookup $geoLookup): GeoLookup
        {
            $geoLookup->LastUpdatedTimestamp = time();
            $geoLookup->CreatedTimestamp = $geoLookup->LastUpdatedTimestamp;

            $Query = QueryBuilder::insert_into('geo', [
                'ip_address' => $this->khm->getDatabase()->real_escape_string($geoLookup->IPAddress),
                'ip_version' => (int)$geoLookup->IPVersion,
                'source' => $this->khm->getDatabase()->real_escape_string($geoLookup->Source),
                'continent' => $this->khm->getDatabase()->real_escape_string($geoLookup->Continent),
                'continent_code' => $this->khm->getDatabase()->real_escape_string($geoLookup->ContinentCode),
                'country' => $this->khm->getDatabase()->real_escape_string($geoLookup->Country),
                'country_code' => $this->khm->getDatabase()->real_escape_string($geoLookup->CountryCode),
                'region' => $this->khm->getDatabase()->real_escape_string($geoLookup->Region),
                'region_code' => $this->khm->getDatabase()->real_escape_string($geoLookup->RegionCode),
                'city' => $this->khm->getDatabase()->real_escape_string($geoLookup->City),
                'zip_code' => ($geoLookup->ZipCode == null ? null : $this->khm->getDatabase()->real_escape_string($geoLookup->ZipCode)),
                'latitude' => (float)$geoLookup->Latitude,
                'longitude' => (float)$geoLookup->Longitude,
                'timezone' => $this->khm->getDatabase()->real_escape_string($geoLookup->Timezone),
                'offset' => (int)$geoLookup->Offset,
                'currency' => $this->khm->getDatabase()->real_escape_string($geoLookup->Currency),
                'isp' => ($geoLookup->ISP == null ? null : $this->khm->getDatabase()->real_escape_string($geoLookup->ISP)),
                'organization' => ($geoLookup->Organization == null ? : $this->khm->getDatabase()->real_escape_string($geoLookup->Organization)),
                '`as`' => $this->khm->getDatabase()->real_escape_string($geoLookup->AS),
                'asname' => $this->khm->getDatabase()->real_escape_string($geoLookup->AsName),
                'last_updated_timestamp' => (int)$geoLookup->LastUpdatedTimestamp,
                'created_timestamp' => (int)$geoLookup->CreatedTimestamp
            ]);

            $QueryResults = $this->khm->getDatabase()->query($Query);

            if($QueryResults == false)
            {
                throw new DatabaseException($Query, $this->khm->getDatabase()->error);
            }

            return $geoLookup;
        }

        /**
         * Returns a existing geo record from the database
         *
         * @param string $ip_address
         * @return GeoLookup
         * @throws DatabaseException
         * @throws GeoRecordNotFoundException
         * @noinspection PhpUnused
         */
        public function getRecord(string $ip_address): GeoLookup
        {
            $Query = QueryBuilder::select('geo', [
                'ip_address',
                'ip_version',
                'source',
                'continent',
                'continent_code',
                'country',
                'country_code',
                'region',
                'region_code',
                'city',
                'zip_code',
                'latitude',
                'longitude',
                'timezone',
                'offset',
                'currency',
                'isp',
                'organization',
                '`as`',
                'asname',
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
                throw new GeoRecordNotFoundException('The geo record for the IP \'' . $ip_address . '\' was not found');
            }

            return GeoLookup::fromArray($Row);
        }

        /**
         * Updates an existing geo record in the database
         *
         * @param GeoLookup $geoLookup
         * @return GeoLookup
         * @throws DatabaseException
         * @noinspection PhpCastIsUnnecessaryInspection
         */
        public function updateRecord(GeoLookup $geoLookup): GeoLookup
        {
            $geoLookup->LastUpdatedTimestamp = time();

            $Query = QueryBuilder::update('geo', [
                'source' => $this->khm->getDatabase()->real_escape_string($geoLookup->Source),
                'continent' => $this->khm->getDatabase()->real_escape_string($geoLookup->Continent),
                'continent_code' => $this->khm->getDatabase()->real_escape_string($geoLookup->ContinentCode),
                'country' => $this->khm->getDatabase()->real_escape_string($geoLookup->Country),
                'country_code' => $this->khm->getDatabase()->real_escape_string($geoLookup->CountryCode),
                'region' => $this->khm->getDatabase()->real_escape_string($geoLookup->Region),
                'region_code' => $this->khm->getDatabase()->real_escape_string($geoLookup->RegionCode),
                'city' => $this->khm->getDatabase()->real_escape_string($geoLookup->City),
                'zip_code' => $this->khm->getDatabase()->real_escape_string($geoLookup->ZipCode),
                'latitude' => (float)$geoLookup->Latitude,
                'longitude' => (float)$geoLookup->Longitude,
                'timezone' => $this->khm->getDatabase()->real_escape_string($geoLookup->Timezone),
                'offset' => (int)$geoLookup->Offset,
                'currency' => $this->khm->getDatabase()->real_escape_string($geoLookup->Currency),
                'isp' => $this->khm->getDatabase()->real_escape_string($geoLookup->ISP),
                'organization' => $this->khm->getDatabase()->real_escape_string($geoLookup->Organization),
                '`as`' => $this->khm->getDatabase()->real_escape_string($geoLookup->AS),
                'asname' => $this->khm->getDatabase()->real_escape_string($geoLookup->AsName),
                'last_updated_timestamp' => (int)$geoLookup->LastUpdatedTimestamp,
            ], 'ip_address', $this->khm->getDatabase()->real_escape_string($geoLookup->IPAddress));

            $QueryResults = $this->khm->getDatabase()->query($Query);

            if($QueryResults == false)
            {
                throw new DatabaseException($Query, $this->khm->getDatabase()->error);
            }

            return $geoLookup;
        }
    }