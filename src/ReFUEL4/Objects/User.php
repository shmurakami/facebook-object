<?php

namespace ReFUEL4\FacebookObject\Objects;

class User extends BaseObject
{

    public $isMe = false;

    static protected $_fields = [
        'id',
        'about',
        'address',
        'age_range',
        'bio',
        'birthday',
        'context',
        'currency',
        'devices',
        'education',
        'email',
        'favorite_athletes',
        'favorite_teams',
        'first_name',
        'gender',
        'hometown',
        'inspirational_people',
        'install_type',
        'installed',
        'interested_in',
        'is_shared_login',
        'is_verified',
        'languages',
        'last_name',
        'link',
        'location',
        'locale',
        'meeting_for',
        'middle_name',
        'name',
        'name_format',
        'payment_pricepoints',
        'test_group',
        'political',
        'relationship_status',
        'religion',
        'security_settings',
        'significant_other',
        'sports',
        'suggested_groups',
        'quotes',
        'third_party_id',
        'timezone',
        'token_for_business',
        'updated_time',
        'shared_login_upgrade_required_by',
        'verified',
        'video_upload_limits',
        'viewer_can_send_gift',
        'website',
        'work',
        'cover',
    ];

    static public $_edges = [
        'accounts'     => ['object' => 'Account', 'isList' => true],
        'achievements' => ['object' => 'Achievement', 'isList' => true],
        'activities'   => ['object' => 'Activity', 'isList' => true],
        'adaccounts'   => ['object' => 'AdAccount', 'isList' => true],
    ];

    protected function basePathForEdge()
    {
        if( $this->isMe ){
            return '/me/';
        }
        return '/'. $this->id . '/';
    }


}