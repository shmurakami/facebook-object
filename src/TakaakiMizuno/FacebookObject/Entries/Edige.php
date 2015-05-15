<?php

namespace TakaakiMizuno\FacebookObject\Entries;

class Edge
{

    /** @var \TakaakiMizuno\FacebookObject\Objects\BaseObject  */
    protected $object;

    /** @var  Bool */
    protected $isList;

    /**
     * @param String $object
     * @param Bool $isList
     */
    public function __construct($object, $isList)
    {
        $this->object = $object;
        $this->isList = $isList;
    }

    public function __get($key) {
        switch( $key ){
            case "object":
                return $this->object;
            case "isList":
                return $this->isList;
        }
    }

}