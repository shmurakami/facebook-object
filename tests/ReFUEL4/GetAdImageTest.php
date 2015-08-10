<?php

namespace ReFUEL4\FacebookObject\Tests;

class GetAdImageTest extends TestBase
{
    public function testAdImage()
    {
        $session = $this->getSession();
        $adAccountRepository = new \ReFUEL4\FacebookObject\Repositories\AdAccountRepository($session);
        $adAccounts = $adAccountRepository->all();

        $this->assertTrue(is_array($adAccounts));

        $adAccount = $adAccounts[0];

        $adImageRepository = new \ReFUEL4\FacebookObject\Repositories\AdImageRepository($session);
        $adImage = $adImageRepository->create($adAccount->id, realpath(dirname(__FILE__)) . '/media/sample.jpg');

        $this->assertNotEmpty($adImage->hash);
        $this->assertNotEmpty($adImage->id);
        $this->assertTrue($adImage->url !== null);
    }
}