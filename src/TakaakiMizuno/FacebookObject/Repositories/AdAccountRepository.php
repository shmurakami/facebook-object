<?php

namespace TakaakiMizuno\FacebookObject\Repositories;

use Facebook\FacebookRequest;
use Facebook\FacebookSession;

class AdAccountRepository extends BaseRepository
{

    public function all()
    {
        $list = $this->allWithClass('/me/adaccounts', 'AdAccount');
        return $list;
    }

    public function find($adAccountId)
    {
        $adId = $adAccountId;
        if( preg_match('/^\d+$/', $adAccountId) ){
            $adId = 'act_' . $adAccountId;
        }
        $adAccount = $this->findWithClass('/' . $adId, 'AdAccount');
        return $adAccount;
    }

}