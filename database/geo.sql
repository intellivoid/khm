create table if not exists geo
(
    ip_address             varchar(128) not null comment 'The primary IP address for this record'
        primary key,
    ip_version             int(1)       null comment 'The verison of the IP address',
    source                 varchar(255) null comment 'The source of the last lookup',
    continent              varchar(126) null comment 'Continent name',
    continent_code         varchar(2)   null comment 'Two-letter continent code',
    country                varchar(126) null comment 'Country name',
    country_code           varchar(2)   null comment 'Two-letter country code ISO 3166-1 alpha-2
https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2',
    region                 varchar(126) null comment 'Region/state',
    region_code            varchar(126) null comment 'Region/state short code (FIPS or ISO)',
    city                   varchar(126) null comment 'City',
    zip_code               varchar(64)  null comment 'Zip code',
    latitude               float        null comment 'Latitude',
    longitude              float        null comment 'Longitude',
    timezone               varchar(126) null comment 'Timezone (tz)',
    offset                 int          null comment 'Timezone UTC DST offset in seconds',
    currency               varchar(32)  null comment 'National currency',
    isp                    varchar(126) null comment 'ISP name',
    organization           varchar(126) null comment 'Organization name',
    `as`                   varchar(256) null comment 'AS number and organization, separated by space (RIR). Empty for IP blocks not being announced in BGP tables.',
    asname                 varchar(126) null comment '	AS name (RIR). Empty for IP blocks not being announced in BGP tables.',
    last_updated_timestamp int(255)     null comment 'The Unix Timestamp for when this record was last updated',
    created_timestamp      int          null comment 'The Unix Timestamp for when this record was created',
    constraint geo_ip_address_uindex
        unique (ip_address)
)
    comment 'Table for housing Geo IP lookup records';

