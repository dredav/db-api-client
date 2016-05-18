<?php

namespace ddreher\api\deutschebahn\methods;


class DataException extends \Exception
{
    /**
     * @var string
     */
    protected $errorCode;

    public function __construct($message, $code)
    {
        parent::__construct($message);
        $this->errorCode = $code;
    }
}
