<?php

namespace ReFUEL4\FacebookObject\Repositories;

use Facebook\FacebookRequest;
use Facebook\FacebookSession;
use FacebookAds\Object\Fields\AdImageFields;

class AdImageRepository extends BaseRepository
{

    public function all($adId)
    {
        $id = $this->generateIdFromAdId($adId);
        $list = $this->allWithClass('/'. $id . '/adimages', 'AdImage');
        return $list;
    }

    public function find($id)
    {

    }

    public function create($adId, $filePath)
    {
        $id = $this->generateIdFromAdId($adId);
        $image = new \FacebookAds\Object\AdImage(null, $id);
        $image->{\FacebookAds\Object\Fields\AdImageFields::FILENAME} = $filePath;
        $image->create();
        return new \ReFUEL4\FacebookObject\Objects\AdImage(
            [
                'id'   => $image->{\FacebookAds\Object\Fields\AdImageFields::ID},
                'hash' => $image->{\FacebookAds\Object\Fields\AdImageFields::HASH},
            ],
            $this->_facebook
        );
    }

}