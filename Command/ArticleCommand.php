<?php
namespace VideoGamesRecords\DwhBundle\Command;

use ProjetNormandie\CommonBundle\Command\DefaultCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ArticleCommand extends DefaultCommand
{
    protected function configure()
    {
        $this
            ->setName('vgr-dwh:article')
            ->setDescription('Command post article')
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
            ->addOption(
                'date',
                null,
                InputOption::VALUE_OPTIONAL,
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
        $date = $input->getOption('date');
        if ($date === null) {
            $date = date('Y-m-d');
        }
        switch ($function) {
            case 'top-week':
                $service = $this->getContainer()->get('VideoGamesRecords\DwhBundle\Service\Article');
                $service->postTopWeek($date);
                break;
            case 'top-month':
                $service = $this->getContainer()->get('VideoGamesRecords\DwhBundle\Service\Article');
                $service->postTopMonth($date);
                break;
        }
        $this->end($output);
        return true;
    }
}
