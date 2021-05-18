<?php
namespace VideoGamesRecords\DwhBundle\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use VideoGamesRecords\DwhBundle\Service\ArticleService;

class ArticleCommand extends Command
{
    protected static $defaultName = 'vgr-dwh:article';

    private $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
        parent::__construct();
    }

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
     * @return int
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $function = $input->getArgument('function');
        $date = $input->getOption('date');
        if ($date === null) {
            $date = date('Y-m-d');
        }
        switch ($function) {
            case 'top-week':
                $this->articleService->postTopWeek($date);
                break;
            case 'top-month':
                $this->articleService->postTopMonth($date);
                break;
        }
        return 0;
    }
}
