create table if not exists onion
(
    ip_address                   varchar(126) not null comment 'The primary IP address for this record'
        primary key,
    ip_version                   int          null comment 'The version of the IP address',
    nickname                     varchar(19)  null comment 'Relay nickname consisting of 1–19 alphanumerical characters. ',
    fingerprint                  varchar(40)  null comment 'Relay fingerprint consisting of 40 upper-case hexadecimal characters. ',
    or_addresses                 mediumblob   null comment 'Array of IPv4 or IPv6 addresses and TCP ports or port lists where the relay accepts onion-routing connections. The first address is the primary onion-routing address that the relay used to register in the network, subsequent addresses are in arbitrary order. IPv6 hex characters are all lower-case. ',
    exit_addresses               mediumblob   null comment 'Array of IPv4 addresses that the relay used to exit to the Internet in the past 24 hours. Omitted if array is empty. ',
    dir_address                  varchar(126) null comment 'IPv4 address where the relay accepts directory connections. Omitted if the relay does not accept directory connections. ',
    dir_port                     int          null comment 'The TCP port used for the dir address',
    last_seen_timestamp          int          null comment 'The Unix Timestamp for when this relay was last seen in the network status consensus',
    last_changed_address_or_port int          null comment 'Unix Timestamp for when this relay last stopped announcing an IPv4 or IPv6 address or TCP port where it previously accepted onion-routing or directory connections. This timestamp can serve as indicator whether this relay would be a suitable fallback directory. ',
    first_seen                   int          null comment 'Unix Timestamp when this relay was first seen in a network status consensus. ',
    flags                        mediumblob   null comment 'ZiProto encoded array of relay flags that the directory authorities assigned to this relay. May be omitted if empty. ',
    running                      tinyint(1)   null comment 'Boolean field saying whether this relay was listed as running in the last relay network status consensus. ',
    `exit`                       tinyint(1)   null comment 'Indicates if the exit flag is present',
    fast                         tinyint(1)   null comment 'Indicates if the fast flag is present',
    guard                        tinyint(1)   null comment 'Indicates if the guard flag is present',
    stable                       tinyint(1)   null comment 'Indicates if the stable flag is present',
    valid                        tinyint(1)   null comment 'Indicates if the valid flag is present',
    contact                      text         null comment 'Contact address of the relay operator. Omitted if empty or if descriptor containing this information cannot be found. ',
    platform                     varchar(255) null comment 'Platform string containing operating system and Tor version details. Omitted if empty or if descriptor containing this information cannot be found. ',
    version                      varchar(32)  null comment 'Tor software version without leading "Tor" as reported by the directory authorities in the "v" line of the consensus. Omitted if either the directory authorities or the relay did not report which version the relay runs or if the relay runs an alternative Tor implementation. ',
    version_status               varchar(64)  null comment 'Status of the Tor software version of this relay based on the versions recommended by the directory authorities. Possible version statuses are: "recommended" if a version is listed as recommended; "experimental" if a version is newer than every recommended version; "obsolete" if a version is older than every recommended version; "new in series" if a version has other recommended versions with the same first three components, and the version is newer than all such recommended versions, but it is not newer than every recommended version; "unrecommended" if none of the above conditions hold. Omitted if either the directory authorities did not recommend versions, or the relay did not report which version it runs. ',
    consensus_weight             int          null comment 'Weight assigned to this relay by the directory authorities that clients use in their path selection algorithm. The unit is arbitrary; currently it''s kilobytes per second, but that might change in the future. ',
    last_updated_timestamp       int          null comment 'The Unix Timestamp for when this record was last updated',
    created_timestamp            int          null comment 'The Unix Timestamp for when this record was registered into the database',
    constraint onion_ip_address_uindex
        unique (ip_address)
)
    comment 'Table for housing known Onion relays';

