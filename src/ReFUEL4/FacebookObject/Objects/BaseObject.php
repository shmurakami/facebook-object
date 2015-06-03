<?php

namespace ReFUEL4\FacebookObject\Objects;

use Facebook\FacebookRequest;
use Facebook\FacebookSession;
use ReFUEL4\FacebookObject\Repositories\BaseRepository;

class BaseObject
{

    static public    $_edges         = [];

    static public    $_defaultFields = null;

    static protected $_fields        = ['id'];

    /** @var array */
    protected $_data;

    /** @var \Facebook\FacebookSession */
    protected        $_session;

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
        if (in_array($key, static::$_fields) and array_key_exists($key, $this->_data)) {
            return $this->_data[$key];
        }
        if (array_key_exists($key, static::$_edges)) {
            $path = $this->basePathForEdge() . $key;
            $repository = new \ReFUEL4\FacebookObject\Repositories\BaseRepository($this->_session);
            if (static::$_edges[$key]['isList']) {
                return $repository->allWithClass($path, static::$_edges[$key]['object']);
            } else {
                return $repository->findWithClass($path, static::$_edges[$key]['object']);
            }
        }

        return null;
    }

    public function isError()
    {
        return false;
    }

    protected function basePathForEdge()
    {
        return '/' . $this->id . '/';
    }

}