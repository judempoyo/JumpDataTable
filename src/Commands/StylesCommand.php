<?php
namespace Jump\JumpDataTable\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

#[AsCommand(
    name: '_styles',
    description: 'Configure terminal color scheme',
    hidden: true
)]
class StylesCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $formatter = $output->getFormatter();
        
        // Teal color palette
        $formatter->setStyle('jump', new OutputFormatterStyle('#00BFA6', null, ['bold']));       // Primary teal
        $formatter->setStyle('jump-secondary', new OutputFormatterStyle('#00897B', null, []));  // Darker teal
        $formatter->setStyle('jump-accent', new OutputFormatterStyle('#FF7043', null, []));     // Complementary orange
        
        // UI Elements
        $formatter->setStyle('jump-code', new OutputFormatterStyle('#E0F2F1', '#004D40', []));  // Code blocks
        $formatter->setStyle('jump-highlight', new OutputFormatterStyle('#B2DFDB', null, ['bold'])); // Highlight
        
        return Command::SUCCESS;
    }
}