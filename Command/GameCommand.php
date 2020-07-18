<?php
namespace VideoGamesRecords\DwhBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GameCommand extends DefaultCommand
{
    protected function configure()
    {
        $this
            ->setName('vgr-dwh:game')
            ->setDescription('Command to update table vgr_dwh.game')
            ->addArgument(
                'function',
                InputArgument::REQUIRED,
                'Who do you want to do?'
            )
            ->addOption(
                'debug',
                null,
                InputOption::VALUE_NONE,
                ''
            )
        ;
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
                $service = $this->getContainer()->get('VideoGamesRecords\DwhBundle\Service\Game');
                $service->maj();
                break;
            case 'purge':
                $service = $this->getContainer()->get('VideoGamesRecords\DwhBundle\Service\Game');
                $service->purge();
                break;
        }
        $this->end($output);
        return true;
    }
}
