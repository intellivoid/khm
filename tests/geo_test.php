<?php

    require 'ppm';
    require 'net.intellivoid.khm';

    $khm = new \khm\khm();
    $res = $khm->geoLookup('5.178.86.77');
    var_dump($res);