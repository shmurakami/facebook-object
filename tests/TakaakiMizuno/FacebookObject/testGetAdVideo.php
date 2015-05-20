<?php

namespace TakaakiMizuno\FacebookObject\tests;

class testGetAdVideo extends testBase
{
    public function testAdImage()
    {
        $session = $this->getSession();
        $adAccountRepository = new \TakaakiMizuno\FacebookObject\Repositories\AdAccountRepository($session);
        $adAccounts = $adAccountRepository->all();

        $this->assertTrue(is_array($adAccounts));

        $adAccount = $adAccounts[1];

        $adVideoRepository = new \TakaakiMizuno\FacebookObject\Repositories\AdVideoRepository($session);
        $adVideos = $adVideoRepository->all($adAccount->id);
        $this->assertTrue(is_array($adVideos));
        $this->assertInstanceOf('\TakaakiMizuno\FacebookObject\Objects\AdVideo', $adVideos[0], 'object is AdVideo');

        $adVideo = $adVideoRepository->create($adAccount->id, realpath(dirname(__FILE__)) . '/media/sample.mp4');
        print $adVideo->id;
    }
}