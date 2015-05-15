<?php

namespace TakaakiMizuno\FacebookObject\Objects;

use Facebook\FacebookRequest;
use Facebook\FacebookSession;
use TakaakiMizuno\FacebookObject\Repositories\BaseRepository;

class BaseObject
{

    /** @var array */
    protected $_data;

    /** @var \Facebook\FacebookSession */
    protected $_session;

    protected $_fields = ['id'];

    protected $_edges = [];

    /**
     * @param array $data
     * @param \Facebook\FacebookSession $session
     */
    public function __construct($data, $session)
    {
        $this->_data = $data;
        $this->_session = $session;
    }

    public function __get($key)
    {
        if (in_array($key, $this->_fields) and array_key_exists($key, $this->_data)) {
            return $this->_data[$key];
        }
        if (array_key_exists($key, $this->_edges)) {
            $path = $this->basePathForEdge() . $key;
            $repository = new \TakaakiMizuno\FacebookObject\Repositories\BaseRepository($this->_session);
            if ($this->_edges[$key]['isList']) {
                return $repository->allWithClass($path, '\TakaakiMizuno\FacebookObject\Objects\\'. $this->_edges[$key]['object']);
            } else {
                return $repository->findWithClass($path, '\TakaakiMizuno\FacebookObject\Objects\\'. $this->_edges[$key]['object']);
            }
        }
        return null;
    }

    protected function basePathForEdge()
    {
        return '/' . $this->id . '/';
    }

}