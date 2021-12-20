<?php

    require 'ppm';
    require 'net.intellivoid.khm';

    $khm = new \khm\khm();
?>

<pre><?PHP print(json_encode($khm->identify(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)); ?></pre>