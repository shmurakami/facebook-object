<?php

namespace ReFUEL4\FacebookObject\Objects;

class AdAccount extends BaseObject
{

    const ACCOUNT_STATUS_ACTIVE                  = 1;
    const ACCOUNT_STATUS_DISABLED                = 2;
    const ACCOUNT_STATUS_UNSETTLED               = 3;
    const ACCOUNT_STATUS_PENDING_REVIEW          = 7;
    const ACCOUNT_STATUS_IN_GRACE_PERIOD         = 9;
    const ACCOUNT_STATUS_TEMPORARILY_UNAVAILABLE = 101;
    const ACCOUNT_STATUS_PENDING_CLOSURE         = 100;

    static public    $_edges         = [
        'adcreatives' => ['object' => 'AdCreative', 'isList' => true],
        'adgroups'    => ['object' => 'AdGroup', 'isList' => true],
        'adimages'    => ['object' => 'AdImage', 'isList' => true],
        'advideos'    => ['object' => 'AdVideo', 'isList' => true],
        'adusers'     => ['object' => 'User', 'isList' => true],
    ];

    static public $_fields = [
        'account_id',
        'id',
        'account_status',
        'age',
        'amount_spent',
        'balance',
        'business_name',
        'capabilities',
        'currency',
        'name',
        'owner',
        'timezone_name',
        'timezone_offset_hours_utc',
        'timezone_id',
    ];

    static public $_defaultFields = [
        'account_id',
        'id',
        'account_status',
        'age',
        'amount_spent',
        'balance',
        'business_name',
        'capabilities',
        'currency',
        'name',
        'owner',
        'timezone_name',
        'timezone_offset_hours_utc',
        'timezone_id',
    ];

    public function getTimeZone()
    {
        return new \DateTimeZone($this->timezone_name);
    }

    protected function basePathForEdge()
    {
        return '/' . $this->_data['id'] . '/';
    }

}