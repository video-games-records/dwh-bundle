<?php
namespace VideoGamesRecords\DwhBundle\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VideoGamesRecords\DwhBundle\Service\Dwh\DwhPlayerHandler;

class PlayerCommand extends Command
{
    protected static $defaultName = 'vgr-dwh:player';

    private DwhPlayerHandler $dwhPlayerHandler;

    public function __construct(DwhPlayerHandler $dwhPlayerHandler)
    {
        $this->dwhPlayerHandler = $dwhPlayerHandler;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('vgr-dwh:player')
            ->setDescription('Command to update table vgr_dwh.player')
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
                $this->dwhPlayerHandler->process();
                break;
            case 'purge':
                $this->dwhPlayerHandler->purge();
                break;
        }
        return Command::SUCCESS;
    }
}
