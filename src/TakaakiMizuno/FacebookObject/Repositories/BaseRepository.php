<?php

namespace TakaakiMizuno\FacebookObject\Repositories;

use Facebook\FacebookRequest;
use Facebook\FacebookSession;
use Facebook\FacebookRequestException;

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

    /**
     * @param \Facebook\GraphObject $object
     * @return \TakaakiMizuno\FacebookObject\Objects\Error|null
     */
    private function checkError($object)
    {
        return ( $object instanceof \TakaakiMizuno\FacebookObject\Objects\Error ) ? true : false;
    }

    /**
     * @param string $path
     * @param string $method
     * @param array $params
     * @return \Facebook\GraphObject|null
     */
    private function _access($method, $path, $params)
    {
        try {
            $result = (new FacebookRequest(
                $this->_session, $method, $path, $params
            ))->execute()->getGraphObject();
            return $result;
        }catch (FacebookRequestException $e){
            $error = $e->getResponse();
            return new \TakaakiMizuno\FacebookObject\Objects\Error($error['error'], $this->_session);
        }
    }

    protected function _all($path)
    {
        $limit = 25;
        $offset = 0;
        $list = [];
        $hasNext = true;
        while ($hasNext) {
            $result = $this->_get($path, $limit, $offset);
            if( $this->checkError($result) ){
                return $result;
            }
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
        $result = $this->_access('GET', $path,
            [
                'limit'  => $limit,
                'offset' => $offset,
            ]
        );
        return $result;
    }

    protected function _find($path)
    {
        $result = $this->_access('GET', $path, []);
        return $result;
    }

    public function allWithClass($path, $class){
        $list = $this->_all($path);
        if( $this->checkError($list) ){
            return $list;
        }
        $result = [];
        foreach( $list as $item ){
            $result[] = new $class(json_decode(json_encode($item), true), $this->_session);
        }
        return $result;
    }

    public function getWithClass($path, $class, $limit = 1000, $offset = 0)
    {
        $list = $this->_get($path, $limit, $offset);
        if( $this->checkError($list) ){
            return $list;
        }
        $result = [];
        foreach( $list as $item ){
            $result[] = new $class($item->asArray(), $this->_session);
        }
        return $result;
    }

    public function findWithClass($path, $class)
    {
        $item = $this->_find($path);
        if( $this->checkError($item) ){
            return $item;
        }
        return new $class($item->asArray(), $this->_session);
    }

}