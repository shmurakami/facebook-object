<?php

namespace ReFUEL4\FacebookObject\Tests;

use FacebookAds\Api;

abstract class TestBase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \Facebook\Facebook
     */
    public function getFacebook()
    {

        $conf = json_decode(file_get_contents(realpath(dirname(__FILE__)) . '/config.json'));
        Api::init($conf->applicationId, $conf->applicationSecret, $conf->accessToken);
        $facebook = new \Facebook\Facebook([
            'app_id'                => $conf->applicationId,
            'app_secret'            => $conf->applicationSecret,
            'default_access_token'  => $conf->accessToken,
            'default_graph_version' => 'v2.4',
        ]);
        return $facebook;
    }
}
