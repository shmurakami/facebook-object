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

    private function getFullNameOfClass($class)
    {
        return '\TakaakiMizuno\FacebookObject\Objects\\' . $class;
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

    protected function _all($path, $param)
    {
        $limit = 25;
        $offset = 0;
        $list = [];
        $hasNext = true;
        while ($hasNext) {
            $result = $this->_get($path, $limit, $offset, $param);
            if( $this->checkError($result) ){
                return $result;
            }
            $data = $result->getProperty('data');
            if( empty($data) ){
                return $list;
            }
            $list += $result->getProperty('data')->asArray();
            $paging = $result->getProperty('paging');
            if (null !== $paging && null != $paging->getProperty('next')) {
                if( preg_match('/(\/act_\d+\/.+)$/', $paging->getProperty('next'), $matches) ){
                    $path = $matches[1];
                    $hasNext = true;
                }
            } else {
                $hasNext = false;
            }
        }
        return $list;
    }

    protected function _get($path, $limit = 1000, $offset = 0, $param)
    {
        $result = $this->_access('GET', $path,
            $param + [
                'limit'  => $limit,
                'offset' => $offset,
            ]
        );
        return $result;
    }

    protected function _find($path, $param)
    {
        $result = $this->_access('GET', $path, $param);
        return $result;
    }

    public function allWithClass($path, $class, $param = []){
        $class = $this->getFullNameOfClass($class);
        if( !empty($class::$_defaultFields) ){
            $param = [
                    'fields' => join(',',$class::$_defaultFields),
                ] + $param;
        }
        $list = $this->_all($path, $param);
        if( $this->checkError($list) ){
            return $list;
        }
        $result = [];
        foreach( $list as $item ){
            $result[] = new $class(json_decode(json_encode($item), true), $this->_session);
        }
        return $result;
    }

    public function getWithClass($path, $class, $limit = 1000, $offset = 0, $param = [])
    {
        $class = $this->getFullNameOfClass($class);
        if( !empty($class::$_defaultFields) ){
            $param = [
                    'fields' => join(',',$class::$_defaultFields),
                ] + $param;
        }
        $list = $this->_get($path, $limit, $offset, $param);
        if( $this->checkError($list) ){
            return $list;
        }
        $result = [];
        foreach( $list as $item ){
            $result[] = new $class($item->asArray(), $this->_session);
        }
        return $result;
    }

    public function findWithClass($path, $class, $param = [])
    {
        $class = $this->getFullNameOfClass($class);
        if( !empty($class::$_defaultFields) ){
            $param = [
                    'fields' => join(',',$class::$_defaultFields),
                ] + $param;
        }
        $item = $this->_find($path, $param);
        if( $this->checkError($item) ){
            return $item;
        }
        return new $class($item->asArray(), $this->_session);
    }

}