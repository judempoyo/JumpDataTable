<?php
namespace Jump\JumpDataTable\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'jump:welcome',
    description: 'Display Jump CLI introduction'
)]
class WelcomeCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->getApplication()->find('_styles')->run($input, $output);

        // Teal-themed ASCII Art
        $io->writeln("<jump>
            ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
            ░░░░░██╗██╗░░░██╗███╗░░░███╗██████╗░░░░░░██████╗░░█████╗░████████╗░█████╗░████████╗░█████╗░██████╗░██╗░░░░░███████╗
            ░░░░░██║██║░░░██║████╗░████║██╔══██╗░░░░░██╔══██╗██╔══██╗╚══██╔══╝██╔══██╗╚══██╔══╝██╔══██╗██╔══██╗██║░░░░░██╔════╝
            ░░░░░██║██║░░░██║██╔████╔██║██████╔╝░░░░░██║░░██║███████║░░░██║░░░███████║░░░██║░░░███████║██████╦╝██║░░░░░█████╗░░
            ██╗░░██║██║░░░██║██║╚██╔╝██║██╔═══╝░░░░░░██║░░██║██╔══██║░░░██║░░░██╔══██║░░░██║░░░██╔══██║██╔══██╗██║░░░░░██╔══╝░░
            ╚█████╔╝╚██████╔╝██║░╚═╝░██║██║░░░░░░░░░░██████╔╝██║░░██║░░░██║░░░██║░░██║░░░██║░░░██║░░██║██████╦╝███████╗███████╗
            ░╚════╝░░╚═════╝░╚═╝░░░░░╚═╝╚═╝░░░░░░░░░░╚═════╝░╚═╝░░╚═╝░░░╚═╝░░░╚═╝░░╚═╝░░░╚═╝░░░╚═╝░░╚═╝╚═════╝░╚══════╝╚══════╝
            ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
</jump>");

        $io->writeln([
            "<jump-secondary>JUMP DATATABLE CLI</> - Modern data presentation toolkit",
            "Version: <jump-highlight>1.0.0</> | Environment: <jump-highlight>development</>",
            ""
        ]);

        $io->definitionList(
            '🔹 <jump>Core Features:</>',
            ['<jump>make:datatable</>' => 'Generate responsive datatables'],
            ['<jump>make:theme</>' => 'Create custom color schemes'],
            ['<jump>make:filter</>' => 'Build advanced filters'],
            ['<jump>docs</>' => 'Interactive documentation browser']
        );


        $io->section('🚀 Quick Start');
        $io->writeln("  <jump-secondary>1.</> Create a datatable:");
        $io->writeln("     <jump-code> jump make:datatable Products --model=Product </jump-code>\n");
        $io->writeln("  <jump-secondary>2.</> Design a theme:");
        $io->writeln("     <jump-code> jump make:theme Oceanic </jump-code>");

        // Links
        $io->newLine();
        $io->writeln([
            '🌐 <fg=gray>Website:</> <jump-secondary>https://jumpdatatable.com</>',
            '📦 <fg=gray>Packages:</> <jump-secondary>https://packagist.org/packages/jump/datatable</>'
        ]);

        return Command::SUCCESS;
    }
}
