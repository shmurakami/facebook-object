<?php

namespace ReFUEL4\FacebookObject\Tests;

class GetAdVideoTest extends TestBase
{
    public function testAdVideo()
    {
        $facebook = $this->getFacebook();
        $adAccountRepository = new \ReFUEL4\FacebookObject\Repositories\AdAccountRepository($facebook);
        $adAccounts = $adAccountRepository->all();

        $this->assertTrue(is_array($adAccounts));

        $adAccount = $adAccounts[0];

        $adVideoRepository = new \ReFUEL4\FacebookObject\Repositories\AdVideoRepository($facebook);
        $adVideos = $adVideoRepository->all($adAccount->id);
        $this->assertTrue(is_array($adVideos));
        $this->assertInstanceOf('\ReFUEL4\FacebookObject\Objects\AdVideo', $adVideos[0], 'object is AdVideo');

        $adVideo = $adVideoRepository->create($adAccount->id, realpath(dirname(__FILE__)) . '/media/sample.mp4');
        print $adVideo->id;
    }
}