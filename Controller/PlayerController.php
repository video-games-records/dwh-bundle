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
     * @return mixed
     */
    public function getPositions(Request $request)
    {
        $idPlayer = $request->query->get('idPlayer', null);
        return $this->playerService->getPositions($idPlayer);
    }
}
