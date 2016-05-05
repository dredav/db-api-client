<?php

namespace ddreher\api\deutschebahn\methods;

use ddreher\api\deutschebahn\wrappers\Station;


/**
 * 
 */
class Stations extends BaseMethod
{
    /**
     * create the stations method from station id, time and mode
     * @param string $name
     * @return Stations
     */
    public static function create($name)
    {
        return new self([
            'input' => $name
        ]);
    }
    
    /**
     * get the request method name
     * @return string
     */
    public function getName() 
    {
        return 'location.name';
    }
    
    /**
     * @param string $response
     * @return \Generator
     */
    public function parse($response)
    {
        if(!array_key_exists('LocationList', $response)) 
        {
            throw new \InvalidArgumentException('Response data LocationList is missing');
        }
        
        $response = $response['LocationList'];
        if(!array_key_exists('StopLocation', $response)) 
        {
            throw new \InvalidArgumentException('Response data StopLocation is missing');
        }
        
        $response = $response['StopLocation'];
        foreach($response as $location)
        {
            yield new Station($location['id'], $location['name'], $location['lon'], $location['lat']);
        }
    }
}