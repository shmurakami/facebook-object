<?php

namespace ReFUEL4\FacebookObject\Repositories;

use Facebook\Exceptions\FacebookSDKException;
use Facebook\FacebookRequest;
use Facebook\GraphNodes\GraphNodeFactory;

class BaseRepository
{
    /** @var \Facebook\Facebook */
    protected $_facebook;

    /**
     * @param \Facebook\Facebook $facebook
     */
    public function __construct($facebook)
    {
        $this->_facebook = $facebook;
    }

    /**
     * @param \Facebook\GraphNodes\GraphEdge $object
     * @return \ReFUEL4\FacebookObject\Objects\Error|null
     */
    protected function checkError($object)
    {
        return ( $object instanceof \ReFUEL4\FacebookObject\Objects\Error ) ? true : false;
    }

    /**
     * @param  string $adId
     * @return string
     */
    protected function generateIdFromAdId($adId)
    {
        if( preg_match('/^\d+$/', $adId) ){
            return 'act_' . $adId;
        }
        return $adId;
    }

    private function getFullNameOfClass($class)
    {
        return '\ReFUEL4\FacebookObject\Objects\\' . $class;
    }

    /**
     * @param string $path
     * @param string $method
     * @param array $params
     * @return \Facebook\FacebookResponse
     */
    private function _access($method, $path, $params)
    {
        return $this->_facebook->sendRequest($method, $path, $params);
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
            if( !$result->count() ){
                return $list;
            }
            foreach ($result->asArray() as $item) {
                $list[] = $item;
            }
            $paging = $result->getNextCursor();
            if( is_null($paging) ){
                $hasNext = false;
            } else {
                $path = $result->getPaginationUrl('next');
                if (is_null($path)) {
                    $hasNext = false;
                }
            }
        }
        return $list;
    }

    /**
     * @param $path
     * @param int $limit
     * @param int $offset
     * @param $param
     * @return \Facebook\GraphNodes\GraphNode
     */
    protected function _get($path, $limit = 1000, $offset = 0, $param)
    {
        try {
            return $this->_access('GET', $path,
                $param + [
                    'limit'  => $limit,
                    'offset' => $offset,
                ]
            )->getGraphEdge();

        } catch (FacebookSDKException $e) {
            return new \ReFUEL4\FacebookObject\Objects\Error($e->getMessage(), $this->_facebook);
        }
    }

    protected function _find($path, $param)
    {
        try {
            return $this->_access('GET', $path, $param)->getGraphNode();
        } catch (FacebookSDKException $e) {
            return new \ReFUEL4\FacebookObject\Objects\Error($e->getMessage(), $this->_facebook);
        }
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
            $result[] = new $class(json_decode(json_encode($item), true), $this->_facebook);
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
            $result[] = new $class($item->asArray(), $this->_facebook);
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
        return new $class($item->asArray(), $this->_facebook);
    }

}