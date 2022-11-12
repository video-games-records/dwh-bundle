<?php
namespace VideoGamesRecords\DwhBundle\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VideoGamesRecords\DwhBundle\Service\Dwh\DwhGameHandler;

class GameCommand extends Command
{
    protected static $defaultName = 'vgr-dwh:game';

    private DwhGameHandler $dwhGameHandler;

    public function __construct(DwhGameHandler $dwhGameHandler)
    {
        $this->dwhGameHandler = $dwhGameHandler;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('vgr-dwh:game')
            ->setDescription('Command to update table vgr_dwh.game')
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
        switch ($function) {
            case 'maj':
                $this->dwhGameHandler->process();
                break;
            case 'purge':
                $this->dwhGameHandler->purge();
                break;
        }
        return Command::SUCCESS;
    }
}
