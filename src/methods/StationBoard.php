<?php

namespace ddreher\api\deutschebahn\methods;

use ddreher\api\deutschebahn\wrappers\TrainBoard;


class StationBoard extends BaseMethod
{
    const DEPARTURE = 'departure';

    const ARRIVAL = 'arrival';
    
    /**
     * @var string
     */
    protected $mode;

    /**
     * create the station board method from station id, time and mode
     * @param string $id
     * @param \DateTime $dateTime
     * @param string $mode
     * @return StationBoard
     */
    public static function create($id, \DateTime $dateTime, $mode)
    {
        $board = new self([
            'id' => $id,
            'date' => $dateTime->format('Y-m-d'),
            'time' => $dateTime->format('H:i'),
        ]);

        return $board->setMode($mode);
    }

    public static function createWithDirection($fromId, $toId, \DateTime $dateTime, $mode)
    {
        $board = new self([
            'id' => $fromId,
            'direction' => $toId,
            'date' => $dateTime->format('Y-m-d'),
            'time' => $dateTime->format('H:i'),
        ]);

        return $board->setMode($mode);
    }

    /**
     * get the request method name
     * @return string
     */
    public function getName() 
    {
        return $this->mode . 'Board';
    }

    /**
     * set the current board mode
     * @param string $mode
     * @return $this
     */
    public function setMode($mode) 
    {
        if($mode != StationBoard::DEPARTURE && $mode != StationBoard::ARRIVAL)
        {
            throw new \InvalidArgumentException('Invalid StationBoard mode parameter');
        }
        
        $this->mode = $mode;
        
        return $this;
    }

    /**
     * @param array $response
     * @return \Generator
     */
    public function parse($response)
    {
        $mode = ucfirst($this->mode);
        $board = $mode . 'Board';
        
        if(!array_key_exists($board, $response)) 
        {
            throw new \InvalidArgumentException(sprintf('Response data %s is missing', $board));
        }
        
        $response = $response[$board];
	    $this->parseErrors($response);

		if(!array_key_exists($mode, $response))
		{
			throw new \InvalidArgumentException(sprintf('Response data %s is missing', $mode));
		}

	    if(is_int(array_keys($response[$mode])[0]))
        {
            $response = $response[$mode];
        }

        foreach($response as $connection)
        {
            if(is_string($connection))
            {
                continue;
            }

            $journeyDetail = $connection['JourneyDetailRef']['ref'];
            $date = new \Datetime($connection['date'] . ' ' . $connection['time']);
            
            // Fix random typos from api data
            $type = null;
            if(!array_key_exists('type', $connection))
            {
                if(!array_key_exists('tyte', $connection))
                {
                    $type = $connection['tyoe'];
                }
                else
                {
                    $type = $connection['tyte'];
                }
            }
            else
            {
                $type = $connection['type'];
            }
            
            $stop = isset($connection['stop']) ? $connection['stop'] : (isset($connection['stopiop']) ? $connection['stopiop'] : NULL);

            $trainBoard = new TrainBoard(isset($connection['stopid']) ? $connection['stopid'] : 0, $stop, $connection['name'], $type, $date);
            if(array_key_exists('track', $connection))
            {
                $trainBoard->setTrack($connection['track']);
            }

            // decode ref parameter 
            $matches = null;
            $decoded = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;", urldecode($journeyDetail));
            // ref ends with question mark
            preg_match('/\?ref=(.*?\?)/', $decoded, $matches);
            
            $trainBoard->setJourneyData([
                'full' => $journeyDetail,
                'ref' => $matches[1],
            ]);

            if($this->mode == StationBoard::ARRIVAL)
            {
                $trainBoard->setOrigin($connection['origin']);
            }
            else
            {
                $trainBoard->setDirection($connection['direction']);
            }
            
            yield $trainBoard;
        }
    }
}
