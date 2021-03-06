<?php

    namespace khm\Objects;

    use khm\Abstracts\AbstractVersionedSoftware;

    class UserAgentOperatingSystem extends AbstractVersionedSoftware
    {

        /**
         * @var string|null
         */
        public $family;

        /**
         * @var string|null
         */
        public $major;

        /**
         * @var string|null
         */
        public $minor;

        /**
         * @var string|null
         */
        public $patch;

        /**
         * @var string|null
         */
        public $patchMinor;

        /**
         * @return string
         */
        public function toVersion(): string
        {
            return $this->formatVersion($this->major, $this->minor, $this->patch, $this->patchMinor);
        }
    }
