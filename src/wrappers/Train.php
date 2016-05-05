<?php

namespace ddreher\api\deutschebahn\wrappers;


class Train implements IWrapper
{
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $type;
    
    /**
     * @var string
     */
    protected $operator;
    
    /**
     * @var array
     */
    protected $notes = [];

    /**
     * @param $name
     * @param $type
     * @param $operator
     */
    public function __construct($name, $type, $operator)
    {
        $this->name = $name;
        $this->type = $type;
        $this->operator = $operator;
    }

    /**
     * @return Train
     */
    public static function createEmpty()
    {
        return new Train(null, null, null);
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $operator
     * @return $this
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param $priority
     * @param $key
     * @param $note
     * @return $this
     */
    public function addNote($priority, $key, $note)
    {
        if(!array_key_exists($priority, $this->notes))
        {
            $this->notes[$priority] = [];
            krsort($this->notes);
        }
        
        if(array_key_exists($key, $this->notes[$priority]))
        {
            var_dump($this->notes[$priority]);
        }
        
        $this->notes[$priority][$key] = $note;
        
        return $this;
    }

    /**
     * @return array
     */
    public function getNotes()
    {
        return $this->notes;
    }
}