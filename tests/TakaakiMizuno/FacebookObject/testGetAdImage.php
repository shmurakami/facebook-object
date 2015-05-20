<?php

namespace TakaakiMizuno\FacebookObject\tests;

class testGetAdImage extends testBase
{
    public function testAdImage()
    {


        $session = $this->getSession();
        $adAccountRepository = new \TakaakiMizuno\FacebookObject\Repositories\AdAccountRepository($session);
        $adAccounts = $adAccountRepository->all();

        $this->assertTrue(is_array($adAccounts));

        $adAccount = $adAccounts[1];

        print_r($adAccount);

        print_r($adAccount->id);
        print_r($adAccount->account_id);

        $adImageRepository = new \TakaakiMizuno\FacebookObject\Repositories\AdImageRepository($session);
        $adImage = $adImageRepository->create($adAccount->id, realpath(dirname(__FILE__)) . '/media/sample.jpg');
        print $adImage->hash;
    }
}