<?php

    namespace khm\Abstracts;

    abstract class OnionVersionStatus
    {
        const Recommended = 'recommended';

        const Experimental = 'experimental';

        const Obsolete = 'obsolete';

        const NewInSeries = 'new in series';

        const Unrecommended = 'unrecommended';
    }