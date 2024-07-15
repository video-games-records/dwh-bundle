<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use VideoGamesRecords\CoreBundle\Traits as VgrCoreTraits;
use VideoGamesRecords\DwhBundle\Repository\TeamRepository;
use VideoGamesRecords\DwhBundle\Traits\Entity\DateTrait;
use VideoGamesRecords\DwhBundle\Traits\Entity\NbPostDay;

#[ORM\Table(name:'dwh_team')]
#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    use DateTrait;
    use NbPostDay;
    use VgrCoreTraits\Entity\ChartRank0Trait;
    use VgrCoreTraits\Entity\ChartRank1Trait;
    use VgrCoreTraits\Entity\ChartRank2Trait;
    use VgrCoreTraits\Entity\ChartRank3Trait;
    use VgrCoreTraits\Entity\PointChartTrait;
    use VgrCoreTraits\Entity\RankPointChartTrait;
    use VgrCoreTraits\Entity\RankMedalTrait;
    use VgrCoreTraits\Entity\RankPointBadgeTrait;
    use VgrCoreTraits\Entity\PointBadgeTrait;
    use VgrCoreTraits\Entity\NbMasterBadgeTrait;
    use VgrCoreTraits\Entity\PointGameTrait;
    use VgrCoreTraits\Entity\RankPointGameTrait;

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
