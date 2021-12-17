<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace khm\Managers;

    use khm\Exceptions\AbuseRecordNotFoundException;
    use khm\Exceptions\DatabaseException;
    use khm\khm;
    use khm\Objects\AbuseCheck;
    use msqg\QueryBuilder;
    use ZiProto\ZiProto;

    class AbuseManager
    {
        private $khm;

        /**
         * @param khm $khm
         */
        public function __construct(khm $khm)
        {
            $this->khm = $khm;
        }

        /**
         * Registers the record into the database
         *
         * @param AbuseCheck $abuseCheck
         * @return AbuseCheck
         * @throws DatabaseException
         * @noinspection PhpCastIsUnnecessaryInspection
         */
        public function registerRecord(AbuseCheck $abuseCheck): AbuseCheck
        {
            $abuseCheck = AbuseCheck::fromArray($abuseCheck->toArray());
            $abuseCheck->LastUpdatedTimestamp = time();
            $abuseCheck->CreatedTimestamp = $abuseCheck->LastUpdatedTimestamp;
            $Query = QueryBuilder::insert_into('abuse', [
                'ip_address' => $this->khm->getDatabase()->real_escape_string($abuseCheck->IpAddress),
                'is_public' => (int)$abuseCheck->IsPublic,
                'ip_version' => (int)$abuseCheck->IpVersion,
                'is_whitelisted' => (int)$abuseCheck->IsWhitelisted,
                'abuse_confidence_score' => (int)$abuseCheck->AbuseConfidenceScore,
                'isp' => $this->khm->getDatabase()->real_escape_string($abuseCheck->ISP),
                'domain' => $this->khm->getDatabase()->real_escape_string($abuseCheck->Domain),
                'hostname' => $this->khm->getDatabase()->real_escape_string($abuseCheck->Hostname),
                'hostnames' => $this->khm->getDatabase()->real_escape_string(ZiProto::encode($abuseCheck->Hostname)),
                'total_reports' => (int)$abuseCheck->TotalReports,
                'num_distinct_users' => (int)$abuseCheck->NumDistinctUsers,
                'last_reported_at' => (int)$abuseCheck->LastReportedTimestamp,
                'last_updated_timestamp' => (int)$abuseCheck->LastUpdatedTimestamp,
                'created_timestamp' => (int)$abuseCheck->CreatedTimestamp
            ]);

            $QueryResults = $this->khm->getDatabase()->query($Query);

            if($QueryResults == false)
            {
                throw new DatabaseException($Query, $this->khm->getDatabase()->error);
            }

            return $abuseCheck;
        }

        /**
         * Returns an existing record from the database
         *
         * @param string $ip_address
         * @return AbuseCheck
         * @throws AbuseRecordNotFoundException
         * @throws DatabaseException
         */
        public function getRecord(string $ip_address): AbuseCheck
        {
            $Query = QueryBuilder::select('abuse', [
                'ip_address',
                'is_public',
                'ip_version',
                'is_whitelisted',
                'abuse_confidence_score',
                'isp',
                'domain',
                'hostname',
                'hostnames',
                'total_reports',
                'num_distinct_users',
                'last_reported_at',
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
                throw new AbuseRecordNotFoundException('The abuse record for the IP \'' . $ip_address . '\' was not found');
            }

            $Row['hostnames'] = ZiProto::decode($Row['hostnames']);
            return AbuseCheck::fromArray($Row);
        }

        /**
         * Updates an existing record in the database
         *
         * @param AbuseCheck $abuseCheck
         * @return AbuseCheck
         * @throws DatabaseException
         */
        public function updateRecord(AbuseCheck $abuseCheck): AbuseCheck
        {
            $abuseCheck->LastUpdatedTimestamp = time();

            $Query = QueryBuilder::update('abuse', [
                'is_public' => (int)$abuseCheck->IsPublic,
                'is_whitelisted' => (int)$abuseCheck->IsWhitelisted,
                'abuse_confidence_score' => (int)$abuseCheck->AbuseConfidenceScore,
                'isp' => $this->khm->getDatabase()->real_escape_string($abuseCheck->ISP),
                'domain' => $this->khm->getDatabase()->real_escape_string($abuseCheck->Domain),
                'hostname' => $this->khm->getDatabase()->real_escape_string($abuseCheck->Hostname),
                'hostnames' => $this->khm->getDatabase()->real_escape_string(ZiProto::encode($abuseCheck->Hostname)),
                'total_reports' => (int)$abuseCheck->TotalReports,
                'num_distinct_users' => (int)$abuseCheck->NumDistinctUsers,
                'last_reported_at' => (int)$abuseCheck->LastReportedTimestamp,
                'last_updated_timestamp' => (int)$abuseCheck->LastUpdatedTimestamp,
            ], 'ip_address', $this->khm->getDatabase()->real_escape_string($abuseCheck->IpAddress));

            $QueryResults = $this->khm->getDatabase()->query($Query);

            if($QueryResults == false)
            {
                throw new DatabaseException($Query, $this->khm->getDatabase()->error);
            }

            return $abuseCheck;
        }
    }