<?php
namespace VideoGamesRecords\DwhBundle\Manager\Strategy\Table;

use DateInterval;
use DateTime;
use Doctrine\ORM\OptimisticLockException;
use Exception;
use VideoGamesRecords\DwhBundle\Contracts\Strategy\TableStrategyInterface;
use VideoGamesRecords\DwhBundle\Entity\Game as DwhGame;

class GameStrategy extends AbstractTableManager implements TableStrategyInterface
{

    public function supports(string $name): bool
    {
        return $name === self::TYPE_GAME;
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

        $data1 = $this->provider->getNbPostDay($date1, $date2);
        $games = $this->provider->getData();

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
            $this->em->persist($object);
        }
        $this->em->flush();
    }

    /**
     * @throws Exception
     */
    public function purge(): void
    {
        $date = new DateTime();
        $date = $date->sub(DateInterval::createFromDateString('3 years'));

        //----- delete
        $query = $this->em->createQuery('DELETE VideoGamesRecords\DwhBundle\Entity\Game g WHERE g.date < :date');
        $query->setParameter('date', $date->format('Y-m-d'));
        $query->execute();
    }
}
