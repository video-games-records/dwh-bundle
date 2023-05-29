<?php
namespace VideoGamesRecords\DwhBundle\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VideoGamesRecords\DwhBundle\Manager\TableManager;

class TableCommand extends Command
{
    protected static $defaultName = 'vgr-dwh:table';

    private TableManager $tableManager;

    public function __construct(TableManager $tableManager)
    {
        $this->tableManager = $tableManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('vgr-dwh:table')
            ->setDescription('Command to update table')
            ->addArgument(
                'table',
                InputArgument::REQUIRED,
                'Who do you want to do?'
            )
            ->addArgument(
                'function',
                InputArgument::REQUIRED,
                'Who do you want to do?'
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
        $function = $input->getArgument('function');
        $table = $input->getArgument('table');
        $this->tableManager->getStrategy($table)->$function();
        return Command::SUCCESS;
    }
}
