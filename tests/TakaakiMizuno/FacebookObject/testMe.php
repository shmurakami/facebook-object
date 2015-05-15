<?php

namespace TakaakiMizuno\FacebookObject\tests;

class testMe extends testBase
{
    public function testGetMe()
    {

        $session = $this->getSession();
        $repository = new \TakaakiMizuno\FacebookObject\Repositories\UserRepository($session);
        $me = $repository->me();

        $this->assertInstanceOf('\TakaakiMizuno\FacebookObject\Objects\User', $me, 'me object is UserObject');
        $this->assertTrue($me->isMe);
        $this->assertNotEmpty($me->id, 'ID exists in me object');
        $this->assertNotEmpty($me->name, 'name exists in me object');
        $this->assertNotEmpty($me->email, 'email exists in me object');

        $user = $repository->find(650033667);
        $this->assertFalse($user->isMe);
        $this->assertNotEmpty($user->id, 'ID exists in user object');
        $this->assertNotEmpty($user->name, 'name exists in user object');

        $adaccounts = $me->adaccounts;
        $this->assertTrue(is_array($adaccounts));


    }
}