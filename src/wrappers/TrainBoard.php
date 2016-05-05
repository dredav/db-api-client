<?php

namespace ddreher\api\deutschebahn\wrappers;


class TrainBoard implements IWrapper
{
    /**
     * @var string
     */
    protected $id;
    
    /**
     * @var string
     */
    protected $stopName;
    
    /**
     * @var string
     */
    protected $trainName;
    
    /**
     * @var string
     */
    protected $trainType;
    
    /**
     * @var \DateTime
     */
    protected $date;
    
    /**
     * @var string
     */
    protected $direction;
    
    /**
     * @var string
     */
    protected $origin;
    
    /**
     * @var string
     */
    protected $track;
    
    /**
     * @var array
     */
    protected $journeyData;

    /**
     * @param $id
     * @param $stopName
     * @param $trainName
     * @param $trainType
     * @param $date
     */
    public function __construct($id, $stopName, $trainName, $trainType, $date)
    {
        $this->id = $id;
        $this->stopName = $stopName;
        $this->trainName = $trainName;
        $this->trainType = $trainType;
        $this->date = $date;
    }

    /**
     * @return TrainBoard
     */
    public static function createEmpty()
    {
        return new TrainBoard(null, null, null, null, null);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStopName()
    {
        return $this->stopName;
    }

    /**
     * @return string
     */
    public function getTrainName()
    {
        return $this->trainName;
    }

    /**
     * @return string
     */
    public function getTrainType()
    {
        return $this->trainType;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param $direction
     * @return $this
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param $origin
     * @return $this
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getTrack()
    {
        return $this->track;
    }

    /**
     * @param $track
     * @return $this
     */
    public function setTrack($track)
    {
        $this->track = $track;
        
        return $this;
    }

    /**
     * @return array
     */
    public function getJourneyData()
    {
        return $this->journeyData;
    }

    /**
     * @param $data
     * @return $this
     */
    public function setJourneyData($data)
    {
        $this->journeyData = $data;
        
        return $this;
    }
}