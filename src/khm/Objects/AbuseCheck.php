<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace khm\Objects;

    class AbuseCheck
    {
        /**
         * The IP Address
         *
         * @var string
         */
        public $IpAddress;

        /**
         * Indicates if the IP address is public or private
         *
         * @var bool
         */
        public $IsPublic;

        /**
         * The version of the IP address
         *
         * @var int
         */
        public $IpVersion;

        /**
         * Indicates if the IP address has been whitelisted by the provider
         *
         * @var bool
         */
        public $IsWhitelisted;

        /**
         * The abuse confidence score, from 0-100
         * 75 and above meaning it's potentially harmful, anything lower is considered safe but questionable
         *
         * @var int
         */
        public $AbuseConfidenceScore;

        /**
         * The name of the service provider for this IP
         *
         * @var string|null
         */
        public $ISP;

        /**
         * The domain address associated with this IP address
         *
         * @var string|null
         */
        public $Domain;

        /**
         * The primary host name of the IP address
         *
         * @var string
         */
        public $Hostname;

        /**
         * An array of hostnames associated with this IP address
         *
         * @var string[]
         */
        public $Hostnames;

        /**
         * The total amount of reports that this IP received
         *
         * @var int
         */
        public $TotalReports;

        /**
         * The number of distinct users that uses this IP address
         *
         * @var int
         */
        public $NumDistinctUsers;

        /**
         * Indicates the last time someone reported the IP for abuse
         *
         * @var int|null
         */
        public $LastReportedTimestamp;

        /**
         * The Unix Timestamp for when this record was last updated
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
         * @noinspection PhpTernaryExpressionCanBeReplacedWithConditionInspection
         * @noinspection PhpCastIsUnnecessaryInspection
         */
        public function toArray(): array
        {
            return [
                'ip_address' => $this->IpAddress,
                'is_public' => ($this->IsPublic == null ? false : (bool)$this->IsPublic),
                'ip_version' => $this->IpVersion,
                'is_whitelisted' => ($this->IsWhitelisted == null ? false : (bool)$this->IsWhitelisted),
                'abuse_confidence_score' => ($this->AbuseConfidenceScore == null ? 0 : (int)$this->AbuseConfidenceScore),
                'isp' => $this->ISP,
                'domain' => $this->Domain,
                'hostname' => $this->Hostname,
                'hostnames' => ($this->Hostnames == null ? [] : $this->Hostnames),
                'total_reports' => ($this->TotalReports == null ? 0 : (int)$this->TotalReports),
                'num_distinct_users' => ($this->NumDistinctUsers == null ? 0 : (int)$this->NumDistinctUsers),
                'last_reported_at' => ($this->LastReportedTimestamp == null ? null : $this->LastReportedTimestamp),
                'last_updated_timestamp' => ($this->LastUpdatedTimestamp == null ? 0 : (int)$this->LastUpdatedTimestamp),
                'created_timestamp' => ($this->CreatedTimestamp == null ? 0 : (int)$this->CreatedTimestamp)
            ];
        }

        /**
         * Constructs object from an array representation
         *
         * @param array $data
         * @return AbuseCheck
         * @noinspection PhpTernaryExpressionCanBeReplacedWithConditionInspection
         */
        public static function fromArray(array $data): AbuseCheck
        {
            $AbuseCheckObject = new AbuseCheck();

            if(isset($data['ip_address']))
                $AbuseCheckObject->IpAddress = $data['ip_address'];

            if(isset($data['is_public']))
                $AbuseCheckObject->IsPublic = (bool)$data['is_public'];

            if(isset($data['ip_version']))
                $AbuseCheckObject->IpVersion = (int)$data['ip_version'];

            if(isset($data['is_whitelisted']))
                $AbuseCheckObject->IsWhitelisted = (bool)$data['is_whitelisted'];

            if(isset($data['abuse_confidence_score']))
                $AbuseCheckObject->AbuseConfidenceScore = (int)$data['abuse_confidence_score'];

            if(isset($data['isp']))
                $AbuseCheckObject->ISP = $data['isp'];

            if(isset($data['domain']))
                $AbuseCheckObject->Domain = $data['domain'];

            if(isset($data['hostname']))
                $AbuseCheckObject->Hostname = $data['hostname'];

            if(isset($data['hostnames']))
                $AbuseCheckObject->Hostnames = $data['hostnames'];

            if(is_array($AbuseCheckObject->Hostnames) == false)
            {
                $AbuseCheckObject->Hostnames = [$AbuseCheckObject->Hostnames];
            }

            if(isset($data['total_reports']))
                $AbuseCheckObject->TotalReports = (int)$data['total_reports'];

            if(isset($data['num_distinct_users']))
                $AbuseCheckObject->NumDistinctUsers = (int)$data['num_distinct_users'];

            if(isset($data['last_reported_at']))
                $AbuseCheckObject->LastReportedTimestamp = (int)$data['last_reported_at'];

            if(isset($data['last_updated_timestamp']))
                $AbuseCheckObject->LastUpdatedTimestamp = (int)$data['last_updated_timestamp'];

            if(isset($data['created_timestamp']))
                $AbuseCheckObject->CreatedTimestamp = (int)$data['created_timestamp'];

            if(isset($data['data']))
            {
                if(isset($data['data']['ipAddress']))
                    $AbuseCheckObject->IpAddress = $data['data']['ipAddress'];

                if(isset($data['data']['isPublic']))
                    $AbuseCheckObject->IsPublic = ($data['data']['isPublic'] == null ? true : (bool)$data['data']['isPublic']);

                if(isset($data['data']['ipVersion']))
                    $AbuseCheckObject->IpVersion = $data['data']['ipVersion'];

                if(isset($data['data']['isWhitelisted']))
                    $AbuseCheckObject->IsWhitelisted = ($data['data']['isWhitelisted'] == null ? false : (bool)$data['data']['isWhitelisted']);

                if(isset($data['data']['abuseConfidenceScore']))
                    $AbuseCheckObject->AbuseConfidenceScore = ($data['data']['abuseConfidenceScore'] == null ? 0 : (int)$data['data']['abuseConfidenceScore']);

                if(isset($data['data']['isp']))
                    $AbuseCheckObject->ISP = $data['data']['isp'];

                if(isset($data['data']['domain']))
                    $AbuseCheckObject->Domain = $data['data']['domain'];

                if(isset($data['data']['hostnames']))
                    $AbuseCheckObject->Hostnames = $data['data']['hostnames'];

                if(count($AbuseCheckObject->Hostnames) > 0)
                    $AbuseCheckObject->Hostname = $AbuseCheckObject->Hostnames[0];

                if(isset($data['data']['totalReports']))
                    $AbuseCheckObject->TotalReports = ($data['data']['totalReports'] == null ? 0 : (int)$data['data']['totalReports']);

                if(isset($data['data']['numDistinctUsers']))
                    $AbuseCheckObject->NumDistinctUsers = ($data['data']['numDistinctUsers'] == null ? 0 : (int)$data['data']['numDistinctUsers']);

                if(isset($data['data']['lastReportedAt']))
                    $AbuseCheckObject->LastReportedTimestamp = ($data['data']['lastReportedAt'] == null ? null : (int)strtotime($data['data']['lastReportedAt']));
            }

            return $AbuseCheckObject;
        }
    }