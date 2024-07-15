<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\Command;

use Exception;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use VideoGamesRecords\DwhBundle\Contracts\DwhInterface;
use VideoGamesRecords\DwhBundle\Manager\TableManager;

class TableCommand extends Command implements DwhInterface
{
    protected static $defaultName = 'vgr-dwh:table';

    private TableManager $tableManager;

    public function __construct(
        #[Autowire(service: 'vgr.dwh.manager.table')]
        TableManager $tableManager
    ) {
        $this->tableManager = $tableManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('vgr-dwh:table')
            ->setDescription('Command to update table')
            ->addArgument(
                'type',
                InputArgument::REQUIRED,
                'Strategy type'
            )
            ->addArgument(
                'function',
                InputArgument::REQUIRED,
                'Call function'
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $type = $input->getArgument('type');
        $function = $input->getArgument('function');


        if (!array_key_exists($type, self::COMMAND_TYPES)) {
            throw new InvalidArgumentException(sprintf('type [%s] is invalid', $type));
        }

        if (!array_key_exists($function, self::COMMAND_FUNCTIONS)) {
            throw new InvalidArgumentException(sprintf('function [%s] is invalid', $function));
        }

        $this->tableManager->getStrategy($type)->$function();
        return Command::SUCCESS;
    }
}
