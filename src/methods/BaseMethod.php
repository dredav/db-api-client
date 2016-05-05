<?php

namespace ddreher\api\deutschebahn\methods;


abstract class BaseMethod
{
    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @param array $parameters
     */
    protected function __construct($parameters)
    {
        if(is_array($parameters) && count($parameters) > 0)
        {
            $this->parameters = $parameters;
        }
    }

    /**
     * get the request method name
     * @return string
     */
    public abstract function getName();
    
    /**
     * get the request parameters
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}