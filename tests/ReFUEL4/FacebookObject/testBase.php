<?php

namespace ReFUEL4\FacebookObject\tests;

use Facebook\FacebookSession;
use FacebookAds\Api;

abstract class testBase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \Facebook\FacebookSession
     */
    public function getSession()
    {

        $conf = json_decode(file_get_contents(realpath(dirname(__FILE__)) . '/config.json'));
        Api::init($conf->applicationId, $conf->applicationSecret, $conf->accessToken);
        FacebookSession::setDefaultApplication($conf->applicationId, $conf->applicationSecret);

        return new FacebookSession($conf->accessToken);
    }
}
