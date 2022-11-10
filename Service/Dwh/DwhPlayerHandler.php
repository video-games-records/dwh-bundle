<?php
namespace VideoGamesRecords\DwhBundle\Service\Dwh;

use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManager;
use Exception;
use VideoGamesRecords\CoreBundle\Repository\PlayerChartRepository as CorePlayerChartRepository;
use VideoGamesRecords\CoreBundle\Repository\PlayerRepository as CorePlayerRepository;
use VideoGamesRecords\DwhBundle\Entity\Player as DwhPlayer;
use VideoGamesRecords\DwhBundle\Interface\DwhTableInterface;

class DwhPlayerHandler implements DwhTableInterface
{
    private EntityManager $dwhEntityManager;
    private EntityManager $defaultEntityManager;

    public function __construct(EntityManager $dwhEntityManager, EntityManager $defaultEntityManager)
    {
        $this->dwhEntityManager = $dwhEntityManager;
        $this->defaultEntityManager = $defaultEntityManager;
    }

    /**
     * @throws Exception
     */
    public function process(): void
    {
        $date1 = new DateTime();
        $date1->sub(new DateInterval('P1D'));
        $date2 = new DateTime();

        /** @var CorePlayerChartRepository $corePlayerChartRepository */
        $corePlayerChartRepository = $this->defaultEntityManager->getRepository('VideoGamesRecords\CoreBundle\Entity\PlayerChart');

        /** @var CorePlayerRepository $corePlayerRepository */
        $corePlayerRepository = $this->defaultEntityManager->getRepository('VideoGamesRecords\CoreBundle\Entity\Player');

        $data1 = $corePlayerChartRepository->getNbPostDay($date1, $date2);
        $data2 = $corePlayerChartRepository->getDataRank();
        $list = $corePlayerRepository->getDataForDwh();

        foreach ($list as $row) {
            $idPlayer = $row['id'];
            $dwhPlayer = new DwhPlayer();
            $dwhPlayer->setDate($date1->format('Y-m-d'));
            $dwhPlayer->setFromArray($row);
            $dwhPlayer->setNbPostDay((isset($data1[$idPlayer])) ? $data1[$idPlayer] : 0);
            if (isset($data2[$idPlayer])) {
                foreach ($data2[$idPlayer] as $key => $value) {
                    $dwhPlayer->setChartRank($key, $value);
                }
            }
            $this->dwhEntityManager->persist($dwhPlayer);
        }

        $this->dwhEntityManager->flush();
    }

    /**
     * @throws Exception
     */
    public function purge(): void
    {
        $date = new DateTime();
        $date = $date->sub(DateInterval::createFromDateString('3 years'));

        //----- delete
        $query = $this->dwhEntityManager->createQuery('DELETE VideoGamesRecords\DwhBundle\Entity\Player p WHERE p.date < :date');
        $query->setParameter('date', $date->format('Y-m-d'));
        $query->execute();
    }
}
