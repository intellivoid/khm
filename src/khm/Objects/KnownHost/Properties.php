<?php

    namespace khm\Objects\KnownHost;

    class Properties
    {
        /**
         * Returns an array representation of the object
         *
         * @return array
         */
        public function toArray(): array
        {
            return [];
        }

        /**
         * Constructs object from an array representation
         *
         * @param array $data
         * @return Properties
         */
        public static function fromArray(array $data): Properties
        {
            $PropertiesObject = new Properties();

            return $PropertiesObject;
        }
    }