<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use VideoGamesRecords\DwhBundle\Repository\PlayerRepository;
use VideoGamesRecords\DwhBundle\Traits\Entity\DateTrait;
use VideoGamesRecords\CoreBundle\Traits as VgrCoreTraits;
use VideoGamesRecords\DwhBundle\Traits\Entity\NbPostDay;

#[ORM\Table(name:'dwh_player')]
#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    use DateTrait;
    use NbPostDay;
    use VgrCoreTraits\Entity\ChartRank0Trait;
    use VgrCoreTraits\Entity\ChartRank1Trait;
    use VgrCoreTraits\Entity\ChartRank2Trait;
    use VgrCoreTraits\Entity\ChartRank3Trait;
    use VgrCoreTraits\Entity\ChartRank4Trait;
    use VgrCoreTraits\Entity\ChartRank5Trait;
    use VgrCoreTraits\Entity\PointChartTrait;
    use VgrCoreTraits\Entity\RankPointChartTrait;
    use VgrCoreTraits\Entity\RankMedalTrait;
    use VgrCoreTraits\Entity\NbChartTrait;
    use VgrCoreTraits\Entity\PointGameTrait;
    use VgrCoreTraits\Entity\RankPointGameTrait;

    #[ORM\Id, ORM\Column]
    private ?int $id;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank6 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank7 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank8 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank9 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank10 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank11 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank12 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank13 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank14 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank15 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank16 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank17 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank18 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank19 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank20 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank21 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank22 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank23 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank24 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank25 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank26 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank27 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank28 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank29 = 0;

    #[ORM\Column(nullable: false, options: ['default' => 0])]
    private int $chartRank30 = 0;

    public function __toString()
    {
        return sprintf('%s [%s]', $this->id, $this->id);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setChartRank(int $rank, int $nb): void
    {
        $var = 'chartRank' . $rank;
        $this->$var = $nb;
    }

    public function getChartRank(int $rank): int
    {
        $var = 'chartRank' . $rank;
        return $this->$var;
    }

    public function setFromArray(array $row): void
    {
        foreach ($row as $key => $value) {
            $this->$key = $value;
        }
    }
}
