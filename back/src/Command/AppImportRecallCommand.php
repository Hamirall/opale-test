<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\ImportRecalls;

#[
    AsCommand(
        name: "app-import-recall",
        description: "Import product recalls from an external service"
    )
]
class AppImportRecallCommand extends Command
{
    protected $importRecalls;

    public function __construct(ImportRecalls $importRecalls)
    {
        parent::__construct();
        $this->importRecalls = $importRecalls;
    }

    protected function configure(): void
    {
        $this->setDescription(
            "Import product recalls from an external service"
        );
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $io = new SymfonyStyle($input, $output);

        $results = $this->importRecalls->callApi();

        $this->importRecalls->importRecalls($results["results"]);

        $io->success("Data imported successfully");

        return Command::SUCCESS;
    }
}
