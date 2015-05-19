<?php

namespace TakaakiMizuno\FacebookObject\tests;

use Facebook\FacebookSession;

abstract class testBase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \Facebook\FacebookSession
     */
    public function getSession()
    {
        $conf = json_decode(file_get_contents(realpath(dirname(__FILE__)) . '/config.json'));
        FacebookSession::setDefaultApplication($conf->applicationId, $conf->applicationSecret);

        return new FacebookSession($conf->accessToken);
    }
}
