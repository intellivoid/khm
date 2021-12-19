<?php

    namespace khm\Classes;

    class RegexLoader
    {
        /**
         * Loads the mobile1.regex file
         *
         * @return string
         */
        public static function getMobile1(): string
        {
            $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'mobile1.regex';
            return file_get_contents($path);
        }

        /**
         * Loads the mobile1.regex file
         *
         * @return string
         */
        public static function getMobile2(): string
        {
            $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'mobile2.regex';
            return file_get_contents($path);
        }

        /**
         * Loads the regexes.json
         *
         * @return array
         */
        public static function getRegex(): array
        {
            $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'regexes.json';
            return json_decode(file_get_contents($path), true);
        }
    }