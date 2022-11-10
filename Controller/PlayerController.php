<?php

namespace VideoGamesRecords\DwhBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use VideoGamesRecords\DwhBundle\Repository\PlayerRepository;

/**
 * Class PlayerController
 */
class PlayerController extends AbstractController
{
    private PlayerRepository $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }


    /**
     * @param Request $request
     * @return array
     */
    public function getPositions(Request $request): array
    {
        $idPlayer = $request->query->get('idPlayer', null);
        $object = $this->playerRepository->findOneBy(array('id' => $idPlayer), array('date' => 'DESC'));
        return array(
            $object->getChartRank1(),
            $object->getChartRank2(),
            $object->getChartRank3(),
            $object->getChartRank(4),
            $object->getChartRank(5),
            $object->getChartRank(6),
            $object->getChartRank(7),
            $object->getChartRank(8),
            $object->getChartRank(9),
            $object->getChartRank(10),
            $object->getChartRank(11),
            $object->getChartRank(12),
            $object->getChartRank(13),
            $object->getChartRank(14),
            $object->getChartRank(15),
            $object->getChartRank(16),
            $object->getChartRank(17),
            $object->getChartRank(18),
            $object->getChartRank(19),
            $object->getChartRank(20),
            $object->getChartRank(21),
            $object->getChartRank(22),
            $object->getChartRank(23),
            $object->getChartRank(24),
            $object->getChartRank(25),
            $object->getChartRank(26),
            $object->getChartRank(27),
            $object->getChartRank(28),
            $object->getChartRank(29),
            $object->getChartRank(30),
        );
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getMedalsByTime(Request $request): array
    {
         $idPlayer = $request->query->get('idPlayer', null);
         $list = $this->playerRepository->findBy(array('id' => $idPlayer), array('date' => 'ASC'));

         $return = [
             'rank0' => [],
             'rank1' => [],
             'rank2' => [],
             'rank3' => [],
             'date' => [],
         ];
         foreach ($list as $object) {
            $return['rank0'][] = $object->getChartRank0();
            $return['rank1'][] = $object->getChartRank1();
            $return['rank2'][] = $object->getChartRank2();
            $return['rank3'][] = $object->getChartRank3();
            $return['date'][] = $object->getDate();
         }
         return $return;
    }
}
