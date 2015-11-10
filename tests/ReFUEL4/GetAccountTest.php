<?php

namespace ReFUEL4\FacebookObject\Tests;

class GetAccountTest extends TestBase
{
    public function testAdAccount()
    {

        $facebook = $this->getFacebook();
        $repository = new \ReFUEL4\FacebookObject\Repositories\AdAccountRepository($facebook);
        $adAccounts = $repository->all();
        $this->assertTrue(is_array($adAccounts));

        $adAccount = $adAccounts[0];
        $this->assertInstanceOf('\ReFUEL4\FacebookObject\Objects\AdAccount', $adAccount, 'object is AdAccount');
        $this->assertInstanceOf('DateTimeZone', $adAccount->getTimeZone(), 'Check Time Zone');

        $adImages = $adAccount->adimages;

        $this->assertTrue(is_array($adImages));
        $adImage = $adImages[0];

        $this->assertInstanceOf('\ReFUEL4\FacebookObject\Objects\AdImage', $adImage, 'object is AdImage');
        $this->assertNotEmpty($adImage->permalink_url, 'Permalink Exists');

        $adVideos = $adAccount->advideos;

        $this->assertTrue(is_array($adVideos));
        $adVideo = $adVideos[0];

        $this->assertInstanceOf('\ReFUEL4\FacebookObject\Objects\AdVideo', $adVideo, 'object is AdVideo');

    }
}