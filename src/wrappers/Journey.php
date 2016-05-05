<?php

namespace ddreher\api\deutschebahn\wrappers;


class Journey implements IWrapper
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
     * Journey constructor.
     * @param string $id
     * @param string $name
     * @param string $longitude
     * @param string $latitude
     */
    public function __construct($id, $name, $longitude, $latitude)
    {
        $this->id = $id;
        $this->name = $name;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }

    /**
     * @return Journey
     */
    public static function createEmpty()
    {
        return new Journey(null, null, null, null);
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
}