<?php

namespace ddreher\api\deutschebahn\methods;

use ddreher\api\deutschebahn\DBClient;


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

    /**
     * @param array $response
     * @return \Generator
     */
    public abstract function parse($response);

    /**
     * @param DBClient $client
     * @param array $parameters
     * @param bool $rawResponse
     * @return string|array
     * @throws \Exception
     */
    public function request(DBClient $client, array $parameters, $rawResponse)
    {
        $response = $client->getHttpClient()->request('GET', $client->getApiUrl() . $this->getName(), $parameters);

        if($response->getStatusCode() == 200)
        {
            $content = $response->getBody()->getContents();
            if($rawResponse)
            {
                return $content;
            }

            $parsed = json_decode($content, true);
            if(is_null($parsed))
            {
                throw new \Exception(sprintf('Invalid response \'%s\'.', $content));
            }

            return $this->parse($parsed);
        }

        throw new \Exception(sprintf('Invalid response code %s.', $response->getStatusCode()));
    }
}
