<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\Traits\Entity;

use Doctrine\ORM\Mapping as ORM;

trait NbPostDay
{
    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $nbPostDay = 0;

    public function getNbPostDay(): int
    {
        return $this->nbPostDay;
    }

    public function setNbPostDay(int $nbPostDay): void
    {
        $this->nbPostDay = $nbPostDay;
    }
}
