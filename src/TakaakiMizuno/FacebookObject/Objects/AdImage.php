<?php

namespace TakaakiMizuno\FacebookObject\Objects;

class AdImage extends BaseObject
{

    static public $_fields = [
        'id',
        'account_id',
        'url',
        'url_128',
        'creatives',
        'id',
        'width',
        'height',
        'original_width',
        'original_height',
        'created_time',
        'name',
        'permalink_url',
        'status',
        'updated_time',
    ];

    static public $_defaultFields = [
        'account_id',
        'url',
        'url_128',
        'creatives',
        'id',
        'width',
        'height',
        'original_width',
        'original_height',
        'created_time',
        'name',
        'permalink_url',
        'status',
        'updated_time',
    ];

    public function getTimeZone()
    {
        return new \DateTimeZone($this->timezone_name);
    }

}