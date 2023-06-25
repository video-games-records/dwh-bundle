<?php

namespace VideoGamesRecords\DwhBundle\Controller\Player;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use VideoGamesRecords\DwhBundle\Repository\PlayerRepository;

class GetMedalsByTime extends AbstractController
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
    public function __invoke(Request $request): array
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
