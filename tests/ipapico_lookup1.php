<?php

    require 'ppm';
    require 'net.intellivoid.khm';

    $api = new \khm\ThirdParty\IpAPIco();

    var_dump($api->get('91.198.174.192'));