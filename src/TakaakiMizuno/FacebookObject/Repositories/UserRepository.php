<?php

namespace TakaakiMizuno\FacebookObject\Repositories;

use Facebook\FacebookRequest;
use Facebook\FacebookSession;

use TakaakiMizuno\FacebookObject\Objects\User;

class UserRepository extends BaseRepository
{

    public function me()
    {
        $me = $this->findWithClass('/me', '\TakaakiMizuno\FacebookObject\Objects\User');
        $me->isMe = true;

        return $me;
    }

    public function find($id)
    {
        $me = $this->findWithClass('/' . $id, '\TakaakiMizuno\FacebookObject\Objects\User');
        $me->isMe = false;

        return $me;
    }

}