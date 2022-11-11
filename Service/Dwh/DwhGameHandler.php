<?php
namespace VideoGamesRecords\DwhBundle\Service\Dwh;

use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Exception;
use VideoGamesRecords\CoreBundle\Service\Dwh\DwhGameProvider;
use VideoGamesRecords\DwhBundle\Entity\Game as DwhGame;
use VideoGamesRecords\DwhBundle\Interface\DwhTableInterface;

class DwhGameHandler implements DwhTableInterface
{
    private EntityManager $dwhEntityManager;
    private DwhGameProvider $dwhGameProvider;

    public function __construct(EntityManager $dwhEntityManager, DwhGameProvider $dwhGameProvider)
    {
        $this->dwhEntityManager = $dwhEntityManager;
        $this->dwhGameProvider = $dwhGameProvider;
    }

    /**
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function process(): void
    {
        $date1 = new DateTime();
        $date1->sub(new DateInterval('P1D'));
        $date2 = new DateTime();

        $data1 = $this->dwhGameProvider->getNbPostDay($date1, $date2);
        $games = $this->dwhGameProvider->getDataForDwh();

        foreach ($games as $game) {
            $id = $game->getId();
            $object = new DwhGame();
            $object->setDate($date1->format('Y-m-d'));
            $object->setFromArray(
                array(
                    'id' => $game->getId(),
                    'nbPost' => $game->getNbPost(),
                )
            );
            $object->setNbPostDay((isset($data1[$id])) ? $data1[$id] : 0);
            $this->dwhEntityManager->persist($object);
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
        $query = $this->dwhEntityManager->createQuery('DELETE VideoGamesRecords\DwhBundle\Entity\Game g WHERE g.date < :date');
        $query->setParameter('date', $date->format('Y-m-d'));
        $query->execute();
    }
}
