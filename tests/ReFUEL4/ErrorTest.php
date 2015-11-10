<?php

namespace ReFUEL4\FacebookObject\Tests;

class ErrorTest extends TestBase
{
    public function testGetError()
    {

        $facebook = $this->getFacebook();
        $repository = new \ReFUEL4\FacebookObject\Repositories\UserRepository($facebook);

        $error = $repository->find(4321);

        $this->assertInstanceOf('\ReFUEL4\FacebookObject\Objects\Error', $error, 'non exist user id request');
    }
}