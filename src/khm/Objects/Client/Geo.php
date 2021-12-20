<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace khm\Objects\Client;

    use khm\Objects\GeoLookup;

    class Geo
    {
        /**
         * The source of the last lookup
         *
         * @var string
         */
        public $Source;

        /**
         * The continent of the IP address' location
         *
         * @var string
         */
        public $Continent;

        /**
         * Two-Letter continent code
         *
         * @var string
         */
        public $ContinentCode;

        /**
         * Country Name
         *
         * @var string
         */
        public $Country;

        /**
         * Two-Letter country code ISO 3166-1 alpha-2
         *
         * @var string
         */
        public $CountryCode;

        /**
         * Region/state
         *
         * @var string
         */
        public $Region;

        /**
         * Region/state short code (FIPS or ISO)
         *
         * @var string
         */
        public $RegionCode;

        /**
         * City
         *
         * @var string
         */
        public $City;

        /**
         * Zip Code
         *
         * @var string
         */
        public $ZipCode;

        /**
         * Latitude
         *
         * @var float
         */
        public $Latitude;

        /**
         * Longitude
         *
         * @var float
         */
        public $Longitude;

        /**
         * Timezone (tz)
         *
         * @var string
         */
        public $Timezone;

        /**
         * Timezone UTC DST offset in seconds
         *
         * @var int
         */
        public $Offset;

        /**
         * National Currency
         *
         * @var string
         */
        public $Currency;

        /**
         * ISP name
         *
         * @var string|null
         */
        public $ISP;

        /**
         * Organization name
         *
         * @var string|null
         */
        public $Organization;

        /**
         * AS Number and organization, seperated by space (RIR)
         *
         * @var string
         */
        public $AS;

        /**
         * AS Name (RIR). Empty for IP blocks not being announced
         *
         * @var string
         */
        public $AsName;

        /**
         * The unix Timestamp for when this record was last updated
         *
         * @var int
         */
        public $LastUpdatedTimestamp;

        /**
         * The Unix Timestmap for when this record was created
         *
         * @var int
         */
        public $CreatedTimestamp;

        /**
         * Returns an array representation of the object
         *
         * @return array
         * @noinspection PhpCastIsUnnecessaryInspection
         */
        public function toArray(): array
        {
            return [
                'source' => $this->Source,
                'continent' => $this->Continent,
                'continent_code' => $this->ContinentCode,
                'country' => $this->Country,
                'country_code' => $this->CountryCode,
                'region' => $this->Region,
                'region_code' => $this->RegionCode,
                'city' => $this->City,
                'zip_code' => $this->ZipCode,
                'latitude' => (float)$this->Latitude,
                'longitude' => (float)$this->Longitude,
                'timezone' => $this->Timezone,
                'offset' => (int)$this->Offset,
                'currency' => $this->Currency,
                'isp' => (strlen($this->ISP) == 0 ? null : $this->ISP),
                'organization' => (strlen($this->Organization) == 0 ? null : $this->Organization),
                'as' => $this->AS,
                'asname' => $this->AsName,
                'last_updated_timestamp' => (int)$this->LastUpdatedTimestamp,
                'created_timestamp' => (int)$this->CreatedTimestamp
            ];
        }

        /**
         * Constructs object from an array representation of the object
         *
         * @param array $data
         * @param string|null $source
         * @return Geo
         */
        public static function fromArray(array $data, ?string $source=null): Geo
        {
            $geo_object = new Geo();

            if($source !== null && strlen($source) > 0)
                $geo_object->Source = $source;
            if(isset($data['source']))
                $geo_object->Source = $data['source'];

            if(isset($data['continent']))
                $geo_object->Continent = $data['continent'];

            if(isset($data['continent_code']))
                $geo_object->ContinentCode = $data['continent_code'];

            if(isset($data['country']))
                $geo_object->Country = $data['country'];

            if(isset($data['country_code']))
                $geo_object->CountryCode = $data['country_code'];

            if(isset($data['region']))
                $geo_object->Region = $data['region'];

            if(isset($data['region_code']))
                $geo_object->RegionCode = $data['region_code'];

            if(isset($data['city']))
                $geo_object->City = $data['city'];

            if(isset($data['zip_code']))
                $geo_object->ZipCode = $data['zip_code'];

            if(strlen($geo_object->ZipCode) == 0)
                $geo_object->ZipCode = null;

            if(isset($data['latitude']))
                $geo_object->Latitude = $data['latitude'];

            if(isset($data['longitude']))
                $geo_object->Longitude = $data['longitude'];

            $geo_object->Longitude = (float)$geo_object->Longitude;
            $geo_object->Latitude = (float)$geo_object->Latitude;

            if(isset($data['timezone']))
                $geo_object->Timezone = $data['timezone'];

            if(isset($data['offset']))
                $geo_object->Offset = (int)$data['offset'];

            if(isset($data['currency']))
                $geo_object->Currency = $data['currency'];

            if(isset($data['isp']))
                $geo_object->ISP = (strlen($data['isp']) == null ? null : $data['isp']);

            if(isset($data['organization']))
                $geo_object->Organization = $data['organization'];

            if(isset($data['as']))
                $geo_object->AS = $data['as'];

            if(isset($data['asname']))
                $geo_object->AsName = $data['asname'];

            if(isset($data['last_updated_timestamp']))
                $geo_object->LastUpdatedTimestamp = (int)$data['last_updated_timestamp'];

            if(isset($data['created_timestamp']))
                $geo_object->CreatedTimestamp = (int)$data['created_timestamp'];

            return $geo_object;
        }

        /**
         * Constructs object from a geo lookup object
         *
         * @param GeoLookup $geoLookup
         * @return Geo
         */
        public static function fromGeoLookup(GeoLookup $geoLookup): Geo
        {
            return Geo::fromArray($geoLookup->toArray());
        }
    }