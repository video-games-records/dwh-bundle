<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\Scheduler\Handler;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use VideoGamesRecords\DwhBundle\Manager\TableManager;
use VideoGamesRecords\DwhBundle\Scheduler\Message\UpdateTable;

#[AsMessageHandler]
class UpdateTableHandler
{
    public function __construct(
        #[Autowire(service: 'vgr.dwh.manager.table')]
        private readonly TableManager $tableManager
    ) {
    }

    public function __invoke(UpdateTable $message): void
    {
        $target = $message->getTarget();
        $function = $message->getFunction();

        $this->tableManager->getStrategy($target)->$function();
    }
}
