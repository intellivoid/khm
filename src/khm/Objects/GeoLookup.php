<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace khm\Objects;

    class GeoLookup
    {
        /**
         * The primary IP Address for this record
         *
         * @var string
         */
        public $IPAddress;

        /**
         * The version of the IP address
         *
         * @var int
         */
        public $IPVersion;

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
         * The Unix Timestamp for when this record was created
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
                'ip_address' => $this->IPAddress,
                'ip_version' => (int)$this->IPVersion,
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
         * @return GeoLookup
         */
        public static function fromArray(array $data, ?string $source=null): GeoLookup
        {
            $geo_lookup_object = new GeoLookup();

            if(isset($data['query']))
                $geo_lookup_object->IPAddress = $data['query'];
            if(isset($data['ip']))
                $geo_lookup_object->IPAddress = $data['ip'];
            if(isset($data['ip_address']))
                $geo_lookup_object->IPAddress = $data['ip_address'];

            if(isset($data['ip_version']))
                $geo_lookup_object->IPVersion = $data['ip_version'];

            $geo_lookup_object->IPVersion = (int)$geo_lookup_object->IPVersion;

            if($source !== null && strlen($source) > 0)
                $geo_lookup_object->Source = $source;
            if(isset($data['source']))
                $geo_lookup_object->Source = $data['source'];

            if(isset($data['continent']))
                $geo_lookup_object->Continent = $data['continent'];

            if(isset($data['continentCode']))
                $geo_lookup_object->ContinentCode = $data['continentCode'];
            if(isset($data['continent_code']))
                $geo_lookup_object->ContinentCode = $data['continent_code'];

            if(isset($data['country']))
                $geo_lookup_object->Country = $data['country'];
            if(isset($data['country_name']))
                $geo_lookup_object->Country = $data['country_name'];

            if(isset($data['countryCode']))
                $geo_lookup_object->CountryCode = $data['countryCode'];
            if(isset($data['country_code']))
                $geo_lookup_object->CountryCode = $data['country_code'];

            if(isset($data['region']))
                $geo_lookup_object->Region = $data['region'];
            if(isset($data['regionName']))
                $geo_lookup_object->Region = $data['regionName'];

            if(isset($data['region']))
                $geo_lookup_object->RegionCode = $data['region'];
            if(isset($data['region_code']))
                $geo_lookup_object->RegionCode = $data['region_code'];

            if(isset($data['city']))
                $geo_lookup_object->City = $data['city'];

            if(isset($data['zip']))
                $geo_lookup_object->ZipCode = $data['zip'];
            if(isset($data['postal']))
                $geo_lookup_object->ZipCode = $data['postal'];
            if(isset($data['zip_code']))
                $geo_lookup_object->ZipCode = $data['zip_code'];

            if(strlen($geo_lookup_object->ZipCode) == 0)
                $geo_lookup_object->ZipCode = null;

            if(isset($data['lat']))
                $geo_lookup_object->Latitude = $data['lat'];
            if(isset($data['latitude']))
                $geo_lookup_object->Latitude = $data['latitude'];

            if(isset($data['lon']))
                $geo_lookup_object->Longitude = $data['lon'];
            if(isset($data['longitude']))
                $geo_lookup_object->Longitude = $data['longitude'];

            $geo_lookup_object->Longitude = (float)$geo_lookup_object->Longitude;
            $geo_lookup_object->Latitude = (float)$geo_lookup_object->Latitude;

            if(isset($data['timezone']))
                $geo_lookup_object->Timezone = $data['timezone'];

            if(isset($data['offset']))
                $geo_lookup_object->Offset = (int)$data['offset'];
            if(isset($data['utc_offset']))
                $geo_lookup_object->Offset = (int)$data['utc_offset'];

            if(isset($data['currency']))
                $geo_lookup_object->Currency = $data['currency'];

            if(isset($data['isp']))
                $geo_lookup_object->ISP = (strlen($data['isp']) == null ? null : $data['isp']);

            if(isset($data['org']))
                $geo_lookup_object->Organization = $data['org'];
            if(isset($data['organization']))
                $geo_lookup_object->Organization = $data['organization'];

            if(isset($data['as']))
                $geo_lookup_object->AS = $data['as'];
            if(isset($data['asn']))
                $geo_lookup_object->AS = $data['asn'];

            if(isset($data['asname']))
                $geo_lookup_object->AsName = $data['asname'];

            if(isset($data['last_updated_timestamp']))
                $geo_lookup_object->LastUpdatedTimestamp = (int)$data['last_updated_timestamp'];

            if(isset($data['created_timestamp']))
                $geo_lookup_object->CreatedTimestamp = (int)$data['created_timestamp'];

            // Try to fill in the blanks for missing data
            if($geo_lookup_object->IPVersion == null && $geo_lookup_object->IPAddress !== null)
            {
                if(filter_var($geo_lookup_object->IPAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
                {
                    $geo_lookup_object->IPVersion = 4;
                }

                if(filter_var($geo_lookup_object->IPAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
                {
                    $geo_lookup_object->IPVersion = 6;
                }
            }

            if($geo_lookup_object->Continent == null && $geo_lookup_object->ContinentCode !== null)
            {
                switch(strtoupper($geo_lookup_object->ContinentCode))
                {
                    case 'AF':
                        $geo_lookup_object->Continent = 'Africa';
                        break;

                    case 'AN':
                        $geo_lookup_object->Continent = 'Antarctica';
                        break;

                    case 'AS':
                        $geo_lookup_object->Continent = 'Asia';
                        break;

                    case 'EU':
                        $geo_lookup_object->Continent = 'Europe';
                        break;

                    case 'NA':
                        $geo_lookup_object->Continent = 'North America';
                        break;

                    case 'OC':
                        $geo_lookup_object->Continent = 'Oceania';
                        break;

                    case 'SA':
                        $geo_lookup_object->Continent = 'South America';
                        break;
                }
            }

            if($geo_lookup_object->AsName == null && $geo_lookup_object->AS !== null)
            {
                $asn = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'asn.json');
                $asn = json_decode($asn, true);

                if(isset($asn[strtoupper($geo_lookup_object->AS)]))
                    $geo_lookup_object->AsName = $asn[strtoupper($geo_lookup_object->AS)];

                $asn = null;
            }

            if(strlen((string)$geo_lookup_object->Source) == 0)
                $geo_lookup_object->Source = null;
            if(strlen((string)$geo_lookup_object->Continent) == 0)
                $geo_lookup_object->Continent = null;
            if(strlen((string)$geo_lookup_object->ContinentCode) == 0)
                $geo_lookup_object->ContinentCode = null;
            if(strlen((string)$geo_lookup_object->Country) == 0)
                $geo_lookup_object->Country = null;
            if(strlen((string)$geo_lookup_object->Region) == 0)
                $geo_lookup_object->Region = null;
            if(strlen((string)$geo_lookup_object->RegionCode) == 0)
                $geo_lookup_object->RegionCode = null;
            if(strlen((string)$geo_lookup_object->City) == 0)
                $geo_lookup_object->City = null;
            if(strlen((string)$geo_lookup_object->ZipCode) == 0)
                $geo_lookup_object->ZipCode = null;
            if(strlen((string)$geo_lookup_object->Latitude) == 0)
                $geo_lookup_object->Latitude = null;
            if(strlen((string)$geo_lookup_object->Longitude) == 0)
                $geo_lookup_object->Longitude = null;
            if(strlen((string)$geo_lookup_object->Timezone) == 0)
                $geo_lookup_object->Timezone = null;
            if(strlen((string)$geo_lookup_object->Offset) == 0)
                $geo_lookup_object->Offset = null;
            if(strlen((string)$geo_lookup_object->Currency) == 0)
                $geo_lookup_object->Currency = null;
            if(strlen((string)$geo_lookup_object->Organization) == 0)
                $geo_lookup_object->Organization = null;
            if(strlen((string)$geo_lookup_object->AS) == 0)
                $geo_lookup_object->AS = null;
            if(strlen((string)$geo_lookup_object->AsName) == 0)
                $geo_lookup_object->AsName = null;

            return $geo_lookup_object;
        }
    }