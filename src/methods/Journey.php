<?php

namespace ddreher\api\deutschebahn\methods;

use ddreher\api\deutschebahn\wrappers\JourneyStop;
use ddreher\api\deutschebahn\wrappers\Train;


class Journey extends BaseMethod
{
    /**
     * create the journey method from reference
     * @param string $journeyReference
     * @return Journey
     */
    public static function create($journeyReference)
    {
        return new self([
            'ref' => $journeyReference
        ]);
    }
    
    /**
     * get the request method name
     * @return string
     */
    public function getName() 
    {
        return 'journeyDetail';
    }

    /**
     * @param string $response
     * @return \Generator
     */
    public function parse($response)
    {
        if(!array_key_exists('JourneyDetail', $response)) 
        {
            throw new \InvalidArgumentException('Response data JourneyDetail is missing');
        }
        
        $journey = $response['JourneyDetail'];
        if(!array_key_exists('Stops', $journey)) 
        {
            throw new \InvalidArgumentException('Response data Stops is missing');
        }

        $response = $journey['Stops'];
        if(!array_key_exists('Stop', $response)) 
        {
            throw new \InvalidArgumentException('Response data Stop is missing');
        }
        
        $stops = $response['Stop'];
        foreach($stops as $stop)
        {
            $routeIndex = $stop['routeIdx'];
            
            $departureTime = null;
            if(array_key_exists('depTime', $stop))
            {
                $departureTime = $stop['depTime'];
            }
            
            $arrivalTime = null;
            if (array_key_exists('arrTime', $stop))
            {
                $arrivalTime = $stop['arrTime'];
            }
            
            $train = Train::createEmpty();
            $trainNames = $journey['Names'];
            if(is_int(array_keys($trainNames['Name'])[0]))
            {
                $trainNames = $trainNames['Name'];
            }
            
            $trainTypes = $journey['Types'];
            if(is_int(array_keys($trainTypes['Type'])[0]))
            {
                $trainTypes = $trainTypes['Type'];
            }
            
            $trainOperators = $journey['Operators'];
            if(is_int(array_keys($trainOperators['Operator'])[0]))
            {
                $trainOperators = $trainOperators['Operator'];
            }
            
            $trainNotes = $journey['Notes'];
            if(is_int(array_keys($trainNotes['Note'])[0]))
            {
                $trainNotes = $trainNotes['Note'];
            }
            
            foreach($trainNames as $data)
            {
                if($routeIndex < $data['routeIdxFrom'] || $routeIndex > $data['routeIdxTo'])
                {
                    continue;
                }
                
                $train->setName($data['name']);
                break;
            }
            
            foreach($trainTypes as $data)
            {
                if($routeIndex < $data['routeIdxFrom'] || $routeIndex > $data['routeIdxTo'])
                {
                    continue;
                }
                
                $train->setType($data['type']);
                break;
            }
            
            foreach($trainOperators as $data)
            {
                if($routeIndex < $data['routeIdxFrom'] || $routeIndex > $data['routeIdxTo'])
                {
                    continue;
                }
                
                $train->setOperator($data['name']);
                break;
            }
            
            foreach($trainNotes as $data)
            {
                if($routeIndex < $data['routeIdxFrom'] || $routeIndex > $data['routeIdxTo'])
                {
                    continue;
                }
                
                $train->addNote($data['priority'], trim($data['key']), trim($data['$']));
            }

            yield new JourneyStop($stop['id'], $stop['name'], $stop['lon'], $stop['lat'], $routeIndex, $arrivalTime, $departureTime, $train);
        }
    }
}