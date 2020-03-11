<?php
namespace VideoGamesRecords\DwhBundle\Command;

use ProjetNormandie\CommonBundle\Command\DefaultCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TeamCommand extends DefaultCommand
{
    protected function configure()
    {
        $this->setName('vgr-dwh:team')
            ->setDescription('Command to update table vgr_team')
            ->addArgument(
                'function', InputArgument::REQUIRED, 'Who do you want to do?'
            )
            ->addOption(
                'debug', null, InputOption::VALUE_NONE, ''
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return bool
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->init($input);
        $function = $input->getArgument('function');
        switch ($function) {
            case 'maj':
                $service = $this->getContainer()->get('VideoGamesRecords\DwhBundle\Service\Team');
                $service->maj();
                break;
            case 'purge':
                $service = $this->getContainer()->get('VideoGamesRecords\DwhBundle\Service\Team');
                $service->purge();
                break;
        }
        $this->end($output);
        return true;
    }
}
