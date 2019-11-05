<?php
namespace VideoGamesRecords\DwhBundle\Command;

use ProjetNormandie\CommonBundle\Command\DefaultCommand;
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
                $service = $this->getContainer()->get('dwh.game');
                $service->maj();
                break;
            case 'purge':
                $service = $this->getContainer()->get('dwh.game');
                $service->purge();
                break;
            case 'test':
                $service = $this->getContainer()->get('dwh.game');
                $service->getHtmlTop(
                    new \DateTime('2017-12-04'),
                    new \DateTime('2017-12-10'),
                    new \DateTime('2017-12-11'),
                    new \DateTime('2017-12-17'),
                    20
                );
                break;
        }
        $this->end($output);
        return true;
    }
}
