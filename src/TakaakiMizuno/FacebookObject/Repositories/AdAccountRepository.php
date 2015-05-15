<?php

namespace TakaakiMizuno\FacebookObject\Repositories;

use Facebook\FacebookRequest;
use Facebook\FacebookSession;

class AdAccountRepository extends BaseRepository
{

    public function all()
    {
        $list = $this->_all('me/adaccounts');
        foreach( $list as $item ){

        }
    }

}