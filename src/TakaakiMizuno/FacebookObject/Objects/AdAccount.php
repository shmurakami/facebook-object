<?php

namespace TakaakiMizuno\FacebookObject\Objects;

class AdAccount extends BaseObject
{


    protected function basePathForEdge()
    {
        return '/'. $this->id . '/';
    }


}