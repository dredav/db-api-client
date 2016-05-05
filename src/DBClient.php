<?php

namespace ddreher\api\deutschebahn;

use ddreher\api\deutschebahn\methods\BaseMethod;
use GuzzleHttp\Client;


class DBClient
{
    /**
     * @var
     */
    protected $client;

    /**
     * @var
     */
    protected $apiUrl;

    /**
     * @var array
     */
    protected $parameters = [
        'query' => [
            'format' => 'json',
            'lang' => 'en',
        ],
    ];

    /**
     * DBClient constructor.
     * @param $parameters
     */
    public function __construct($parameters)
    {
        $this->client = new Client();

        $this->apiUrl = 'https://open-api.bahn.de/bin/rest.exe/';
        $this->parameters['query'] = $this->parameters['query'] + $parameters;

        // set default timezone => wait for api timezone support
        @date_default_timezone_set('Europe/Berlin');
    }

    /**
     * @param $key
     * @param $value
     * @throws \Exception
     */
    public function updateParameter($key, $value)
    {
        if(!array_key_exists($key, $this->parameters['query']))
        {
            throw new \Exception(sprintf('Parameter %s not found.', $key));
        }

        $this->parameters['query'][$key] = $value;
    }

    /**
     * @param BaseMethod $method
     * @param bool $rawResponse
     * @return string
     * @throws \Exception
     */
    public function request(BaseMethod $method, $rawResponse = false)
    {
        $parameters = $this->parameters;
        $parameters['query'] = $parameters['query'] + $method->getParameters();

        $response = $this->client->request('GET', $this->apiUrl . $method->getName(), $parameters);

        if($response->getStatusCode() == 200)
        {
            $content = $response->getBody()->getContents();
            if($rawResponse)
            {
                return $content;
            }

            return $method->parse(json_decode($content, true));
        }

        throw new \Exception(sprintf('Invalid response code %s.', $response->getStatusCode()));
    }
}
