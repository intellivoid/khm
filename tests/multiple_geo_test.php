<?php

    require 'ppm';
    require 'net.intellivoid.khm';

    $khm = new \khm\khm();
    $res = $khm->multipleGeoLookup([
        '100.142.29.254',
        '100.142.39.218'
    ]);
    var_dump($res);