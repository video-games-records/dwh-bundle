<?php
namespace VideoGamesRecords\DwhBundle\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VideoGamesRecords\DwhBundle\Service\Dwh\DwhTeamHandler;

class TeamCommand extends Command
{
    protected static $defaultName = 'vgr-dwh:team';

    private DwhTeamHandler $dwhTeamHandler;

    public function __construct(DwhTeamHandler $dwhTeamHandler)
    {
        $this->dwhTeamHandler = $dwhTeamHandler;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('vgr-dwh:team')
            ->setDescription('Command to update table vgr_team')
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
                $this->dwhTeamHandler->process();
                break;
            case 'purge':
                $this->dwhTeamHandler->purge();
                break;
        }
        return 0;
    }
}
