<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace khm\Exceptions;

    use Exception;
    use Throwable;

    class DatabaseException extends Exception
    {
        /**
         * @var string
         */
        private $query;

        /**
         * @var string
         */
        private $database_error;

        /**
         * @param string $query
         * @param string $database_error
         * @param int $code
         * @param Throwable|null $previous
         */
        public function __construct($query="", $database_error="", $code = 0, Throwable $previous = null)
        {
            parent::__construct($database_error, $code, $previous);
            $this->query = $query;
            $this->database_error = $database_error;
            $this->code = $code;
        }

        /**
         * @return string
         */
        public function getQuery(): string
        {
            return $this->query;
        }

        /**
         * @return string
         */
        public function getDatabaseError(): string
        {
            return $this->database_error;
        }
    }