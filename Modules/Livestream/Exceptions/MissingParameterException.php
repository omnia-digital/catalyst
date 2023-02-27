<?php

    namespace App\Exceptions;

    use Illuminate\Support\Collection;

    class MissingParameterException extends OmniaRuntimeException
    {
        /**
         * MissingParameterException constructor.
         *
         * @param string|array    $parameter
         * @param string          $message
         * @param Collection|null $context
         * @param int             $code
         * @param Exception|null  $previous
         */
        public function __construct($parameter, $message = "", Collection $context = null, $code = 500, Exception $previous = null)
        {
            $parameterString = '';
            $parameterPlural = '';

            if (is_array($parameter)){
                $parameterPlural = 's';
                foreach($parameter as $p)
                $parameterString .= $p . ', ';
            }
            $parameterString = rtrim($parameterString,', ');

            $message = "Missing Parameter$parameterPlural: $parameterString : Error: $message ";

            return parent::__construct($message, $context, $code, $previous);
        }
    }
