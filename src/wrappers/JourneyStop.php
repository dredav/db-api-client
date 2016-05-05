<?php

namespace ddreher\api\deutschebahn\wrappers;


class JourneyStop implements IWrapper
{
    /**
     * @var string
     */
    protected $id;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $longitude;
    
    /**
     * @var string
     */
    protected $latitude;
    
    /**
     * @var string
     */
    protected $routeIndex;
    
    /**
     * @var string
     */
    protected $arrivalTime;
    
    /**
     * @var string
     */
    protected $departureTime;
    
    /**
     * @var Train
     */
    protected $train;

    /**
     * @param string $id
     * @param string $name
     * @param string $longitude
     * @param string $latitude
     * @param string $routeIndex
     * @param string $arrivalTime
     * @param string $departureTime
     * @param Train $train
     */
    public function __construct($id, $name, $longitude, $latitude, $routeIndex,  $arrivalTime, $departureTime, $train)
    {
        $this->id = $id;
        $this->name = $name;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->routeIndex = $routeIndex;
        $this->arrivalTime = $arrivalTime;
        $this->departureTime = $departureTime;
        $this->train = $train;
    }

    /**
     * @return JourneyStop
     */
    public static function createEmpty()
    {
        return new JourneyStop(null, null, null, null, null, null, null, null);
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return string
     */
    public function getRouteIndex()
    {
        return $this->routeIndex;
    }

    /**
     * @return string
     */
    public function getArrivalTime()
    {
        return $this->arrivalTime;
    }

    /**
     * @return string
     */
    public function getDepartureTime()
    {
        return $this->departureTime;
    }

    /**
     * @return Train
     */
    public function getTrain()
    {
        return $this->train;
    }
}