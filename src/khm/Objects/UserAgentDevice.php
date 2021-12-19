<?php

    namespace khm\Objects;

    use khm\Abstracts\AbstractSoftware;

    class UserAgentDevice extends AbstractSoftware
    {
        /**
         * @var string|null
         */
        public $brand;

        /**
         * @var string|null
         */
        public $model;
    }
