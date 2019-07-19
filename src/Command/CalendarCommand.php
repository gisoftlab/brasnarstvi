<?php

namespace App\Command;

use App\Service\CalendarService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CalendarCommand extends Command
{
    protected static $defaultName = 'calendar:dayNyDate';

    protected $calendarService;

    /**
     * CalendarCommand constructor.
     * @param CalendarService $calendarService
     */
    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Calendar')
            ->setHelp('')
            ->addArgument('date', InputArgument::REQUIRED, 'date');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Start Process',
            '=============',
            '',
        ]);

        $date = $input->getArgument('date');

        try {
            $day = $this->calendarService->getDayByDate($date);
            $output->writeln('In date '. $date .' is day '. $day);
        } catch (\Exception $e) {
            echo 'Error: ',  $e->getMessage(), "\n";
        }



        $output->writeln('=============');
    }
}
