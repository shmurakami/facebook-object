<?php

namespace ReFUEL4\FacebookObject\tests;

class testGetAdImage extends testBase
{
    public function testAdImage()
    {
        $session = $this->getSession();
        $adAccountRepository = new \ReFUEL4\FacebookObject\Repositories\AdAccountRepository($session);
        $adAccounts = $adAccountRepository->all();

        $this->assertTrue(is_array($adAccounts));

        $adAccount = $adAccounts[1];


        $adImageRepository = new \ReFUEL4\FacebookObject\Repositories\AdImageRepository($session);
        $adImage = $adImageRepository->create($adAccount->id, realpath(dirname(__FILE__)) . '/media/sample.jpg');
        print $adImage->hash;
    }
}