create table if not exists abuse
(
    ip_address             varchar(128) not null comment 'The IP address that this record is for'
        primary key,
    is_public              tinyint(1)   null comment 'Indicates if the IP address is public or private',
    ip_version             int(1)       null comment 'The version of the IP address',
    is_whitelisted         tinyint(1)   null comment 'Indicates if the IP address has been whitelisted by the provider',
    abuse_confidence_score int(3)       null comment 'The abuse confidence score, from 0-100
75 and above meaning it''s potentially harmful, anything lower is considered safe but questionable',
    isp                    varchar(256) null comment 'The Internet Service Provider that owns this IP address',
    domain                 varchar(256) null comment 'The domain name applicable to this IP address if applicable',
    hostname               varchar(526) null comment 'The primary host name of this IP address',
    hostnames              blob         null comment 'ZiProto encoded array of all the hostnames associated with this IP address',
    total_reports          int          null comment 'The amount of reports that this IP address has gotten',
    num_distinct_users     int          null comment 'The number of distinct users that uses this IP address',
    last_reported_at       int          null comment 'The Unix Timestmap for when this IP address was last reported',
    last_updated_timestamp int          null comment 'The Unix Timestmap for when this record was last updated',
    created_timestamp      int          null comment 'The Unix Timestmap for when this record was first registered into the database',
    constraint abuse_ip_address_uindex
        unique (ip_address)
)
    comment 'Table for housing abuse checks on hosts from AbuseIPDB';

