<?php
namespace Jump\JumpDataTable\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'make:theme',
    description: 'Create a custom color theme'
)]
class MakeThemeCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'Theme name')
             ->addOption('teal', null, null, 'Use teal as primary color');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $themeName = $input->getArgument('name');
        $isTeal = $input->getOption('teal');

        // Generate files
        $io->section("<jump>Creating theme:</> $themeName");
        
        if ($isTeal) {
            $io->writeln("✓ Using <jump>teal color palette</> as base");
            $this->generateTealTheme($themeName);
        }

        $io->listing([
            "Created <jump-code>themes/$themeName.json</>",
            "Generated <jump-code>resources/css/$themeName.css</>"
        ]);

        $io->success("Theme '$themeName' ready!");
        $io->writeln("  Use <jump-code>jump compile:theme $themeName</> to build assets");

        return Command::SUCCESS;
    }

    private function generateTealTheme(string $name): void
    {
        // Template with teal as primary
        $theme = [
            'primary' => '#00BFA6',
            'secondary' => '#00897B',
            'text' => '#E0F2F1',
            'background' => '#004D40'
        ];
        
        file_put_contents("themes/$name.json", json_encode($theme, JSON_PRETTY_PRINT));
    }
}