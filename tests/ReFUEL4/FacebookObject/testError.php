<?php

namespace ReFUEL4\FacebookObject\tests;

class testError extends testBase
{
    public function testGetError()
    {

        $session = $this->getSession();
        $repository = new \ReFUEL4\FacebookObject\Repositories\UserRepository($session);

        $error = $repository->find(4321);

        $this->assertInstanceOf('\ReFUEL4\FacebookObject\Objects\Error', $error, 'non exist user id request');
    }
}