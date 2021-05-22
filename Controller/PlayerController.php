<?php

namespace VideoGamesRecords\DwhBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use VideoGamesRecords\DwhBundle\Service\PlayerService;

/**
 * Class PlayerController
 * @Route("/dwh/player")
 */
class PlayerController extends AbstractController
{
    private $playerService;

    public function __construct(PlayerService $playerService)
    {
        $this->playerService = $playerService;
    }


    /**
     * @param Request $request
     * @return array
     */
    public function getPositions(Request $request): array
    {
        $idPlayer = $request->query->get('idPlayer', null);
        return $this->playerService->getPositions($idPlayer);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getMedalsByTime(Request $request): array
    {
        $idPlayer = $request->query->get('idPlayer', null);
        return $this->playerService->getMedalsByTime($idPlayer);
    }
}
