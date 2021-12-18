<?php

    require 'ppm';
    require 'net.intellivoid.khm';

    $api = new \khm\ThirdParty\IpAPI();
    $api->setLanguage('en');
    $api->setFields([
        'status',
        'message',
        'continent',
        'continentCode',
        'country',
        'countryCode',
        'region',
        'regionName',
        'city',
        'district',
        'zip',
        'lat',
        'lon',
        'timezone',
        'offset',
        'currency',
        'isp',
        'org',
        'as',
        'asname',
        'reverse',
        'mobile',
        'proxy',
        'hosting',
        'query'
    ]);

    var_dump($api->get('91.198.174.192'));
    var_dump($api->getBatch([
        '100.142.29.254',
        '100.142.39.218'
    ]));