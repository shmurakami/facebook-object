<?php

namespace ReFUEL4\FacebookObject\Objects;

class Error extends BaseObject
{

    static protected $_fields = [
        'message',
        'type',
        'code',
    ];

    public function isError()
    {
        return true;
    }

}