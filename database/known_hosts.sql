create table if not exists known_hosts
(
    ip_address          varchar(126) not null comment 'The IP address of the known host'
        primary key,
    properties          blob         null comment 'ZiProto encoded blob for this hosts properties',
    last_seen_timestamp int          null comment 'The Unix Timestamp for when this host was last seen',
    created_timestamp   int          null comment 'The Unix Timestamp for when this host was first seen',
    constraint known_hosts_ip_address_uindex
        unique (ip_address)
)
    comment 'Table for housing known hosts and their properties';

