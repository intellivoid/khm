<?php

    namespace khm\Exceptions;

    use Exception;
    use Throwable;

    class NoUserAgentProvidedException extends Exception
    {
        /**
         * @param $message
         * @param $code
         * @param Throwable|null $previous
         * @noinspection PhpMissingParamTypeInspection
         */
        public function __construct($message = "", $code = 0, Throwable $previous = null)
        {
            parent::__construct($message, $code, $previous);
            $this->message = $message;
            $this->code = $code;
        }
    }