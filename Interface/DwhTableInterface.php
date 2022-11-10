<?php
namespace VideoGamesRecords\DwhBundle\Interface;

interface DwhTableInterface
{
    public function process() : void;

    public function purge() : void;
}