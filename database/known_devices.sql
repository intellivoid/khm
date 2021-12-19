create table if not exists known_devices
(
    ip_address          varchar(126) null comment 'The IP address of the host',
    device_fingerprint  varchar(126) null comment 'The fingerprint of the device',
    properties          blob         null comment 'ZiProto encoded blob of properties associated with this device',
    last_seen_timestamp int          null comment 'The Unix Timestamp for when this device and host was last seen',
    created_timestamp   int          null comment 'The Unix Timestamp for when this record was first registered',
    constraint known_devices_ip_address_device_fingerprint_uindex
        unique (ip_address, device_fingerprint),
    constraint known_devices_devices_fingerprint_fk
        foreign key (device_fingerprint) references devices (fingerprint),
    constraint known_devices_known_hosts_ip_address_fk
        foreign key (ip_address) references known_hosts (ip_address)
)
    comment 'A table for housing the relationship between a host and a device to detect if a device is using multiple hosts';

create index known_devices_device_fingerprint_index
    on known_devices (device_fingerprint);

create index known_devices_ip_address_index
    on known_devices (ip_address);

