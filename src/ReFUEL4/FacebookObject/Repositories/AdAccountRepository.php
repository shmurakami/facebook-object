<?php

namespace ReFUEL4\FacebookObject\Repositories;

use Facebook\FacebookRequest;
use Facebook\FacebookSession;

class AdAccountRepository extends BaseRepository
{

    public function all()
    {
        $list = $this->allWithClass('/me/adaccounts', 'AdAccount');
        return $list;
    }

    public function find($adId)
    {
        $id = $this->generateIdFromAdId($adId);
        $adAccount = $this->findWithClass('/' . $id, 'AdAccount');
        return $adAccount;
    }

}