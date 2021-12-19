create table devices
(
    fingerprint         varchar(126) not null comment 'The fingerprint of the device',
    user_agent          varchar(255)      not null comment 'The full raw user agent string of the device',
    os_family           varchar(255) null comment 'The Operating System family of the user agent',
    os_version          varchar(126) null comment 'The version of the operating system',
    device_family       varchar(255) null comment 'The family of the device',
    device_brand        varchar(255) null comment 'The brand of the device',
    device_model        varchar(255) null comment 'The model of the device',
    browser_family      varchar(255) null comment 'The family of the web browser that''s being used',
    browser_version     varchar(255) null comment 'The version of the browser that''s being used',
    mobile_browser      bool         null comment 'Indicates if the browser is on a mobile platform',
    mobile_device       bool         null comment 'Indicates if the device is a mobile device',
    last_seen_timestamp int          null comment 'The Unix Timestamp for when this device was last seen',
    created_timestamp   int          null comment 'The Unix Timestamp for when this record was first registered into the database',
    constraint devices_pk
        primary key (fingerprint)
)
    comment 'Table for housing known devices and their properties';

create unique index devices_fingerprint_uindex
    on devices (fingerprint);

create unique index devices_user_agent_uindex
    on devices (user_agent);

