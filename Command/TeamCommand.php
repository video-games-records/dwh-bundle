<?php
namespace VideoGamesRecords\DwhBundle\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VideoGamesRecords\DwhBundle\Service\TeamService;

class TeamCommand extends Command
{
    protected static $defaultName = 'vgr-dwh:team';

    private $service;

    public function __construct(TeamService $service)
    {
        $this->service = $service;
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
     * @return bool
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $function = $input->getArgument('function');
        switch ($function) {
            case 'maj':
                $this->service->maj();
                break;
            case 'purge':
                $this->service->purge();
                break;
        }
        return 0;
    }
}
