<?php

namespace TakaakiMizuno\FacebookObject\tests;

class testError extends testBase
{
    public function testGetError()
    {

        $session = $this->getSession();
        $repository = new \TakaakiMizuno\FacebookObject\Repositories\UserRepository($session);

        $error = $repository->find(4321);

        $this->assertInstanceOf('\TakaakiMizuno\FacebookObject\Objects\Error', $error, 'non exist user id request');
    }
}