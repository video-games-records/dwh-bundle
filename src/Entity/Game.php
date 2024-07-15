<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use VideoGamesRecords\DwhBundle\Repository\GameRepository;
use VideoGamesRecords\CoreBundle\Traits as VgrCoreTraits;
use VideoGamesRecords\DwhBundle\Traits\Entity\DateTrait;
use VideoGamesRecords\DwhBundle\Traits\Entity\NbPostDay;

#[ORM\Table(name:'dwh_game')]
#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    use DateTrait;
    use NbPostDay;
    use VgrCoreTraits\Entity\NbPostTrait;

    #[ORM\Id, ORM\Column]
    private ?int $id;

    public function __toString()
    {
        return sprintf('%s [%s]', $this->id, $this->id);
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setFromArray(array $row): void
    {
        foreach ($row as $key => $value) {
            $this->$key = $value;
        }
    }
}
