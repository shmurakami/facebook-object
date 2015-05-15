<?php

namespace TakaakiMizuno\FacebookObject\Repositories;

use Facebook\FacebookRequest;
use Facebook\FacebookSession;

class BaseRepository
{
    /** @var \Facebook\FacebookSession */
    protected $_session;

    /**
     * @param \Facebook\FacebookSession $session
     */
    public function __construct($session)
    {
        $this->_session = $session;
    }

    protected function _all($path)
    {
        $limit = 25;
        $offset = 0;
        $list = [];
        $hasNext = true;
        while ($hasNext) {
            $result = $this->_get($path, $limit, $offset);
            $list += $result->getProperty('data')->asArray();
            $paging = $result->getProperty('paging');
            if (null !== $paging && null != $paging->getProperty('next')) {
                $hasNext = true;
            } else {
                $hasNext = false;
            }
        }
        return $list;
    }

    protected function _get($path, $limit = 1000, $offset = 0)
    {
        $result = (new FacebookRequest(
            $this->_session, 'GET', $path, [
                'limit'  => $limit,
                'offset' => $offset,
            ]
        ))->execute()->getGraphObject();
        return $result;
    }

    protected function _find($path)
    {
        $object = (new FacebookRequest(
            $this->_session, 'GET', $path
        ))->execute()->getGraphObject();
        return $object;
    }

    public function allWithClass($path, $class){
        $list = $this->_all($path);
        $result = [];
        foreach( $list as $item ){
            $result[] = new $class(json_decode(json_encode($item), true), $this->_session);
        }
        return $result;
    }

    public function getWithClass($path, $class, $limit = 1000, $offset = 0)
    {
        $list = $this->_get($path, $limit, $offset);
        $result = [];
        foreach( $list as $item ){
            $result[] = new $class($item->asArray(), $this->_session);
        }
        return $result;
    }

    public function findWithClass($path, $class)
    {
        $item = $this->_find($path);
        return new $class($item->asArray(), $this->_session);
    }

}