<?php

namespace ReFUEL4\FacebookObject\Repositories;

use Facebook\FacebookRequest;
use Facebook\FacebookSession;
use FacebookAds\Object\Fields\AdImageFields;

class AdVideoRepository extends BaseRepository
{

    public function all($adId)
    {
        $id = $this->generateIdFromAdId($adId);
        $list = $this->allWithClass('/'. $id . '/advideos', 'AdVideo');
        return $list;
    }

    public function find($id)
    {
        return $this->findWithClass('/' . $id, 'AdVideo');
    }

    public function create($adId, $filePath)
    {
        $id = $this->generateIdFromAdId($adId);
        $image = new \FacebookAds\Object\AdVideo(null, $id);
        $image->{\FacebookAds\Object\Fields\AdVideoFields::SOURCE} = $filePath;
        $image->create();
        return new \ReFUEL4\FacebookObject\Objects\AdVideo(
            [
                'id' => $image->{\FacebookAds\Object\Fields\AdVideoFields::ID},
            ],
            $this->_session
        );
    }

}