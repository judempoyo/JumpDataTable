<?php
namespace Jump\JumpDataTable;

use Jump\JumpDataTable\Commands\WelcomeCommand;
use Jump\JumpDataTable\Commands\StylesCommand;
use Jump\JumpDataTable\Commands\MakeThemeCommand;
use Symfony\Component\Console\Application;

class JumpApplication extends Application
{
    public function __construct()
    {
        parent::__construct('JUMP DATATABLE CLI', '1.0.0');
        
        $this->addCommands([
            new WelcomeCommand(),
            new StylesCommand(),
            new MakeThemeCommand()
        ]);
        
        $this->setDefaultCommand('jump:welcome');
    }

    public function getLongVersion(): string
    {
        return sprintf(
            "\n<jump>%s</> - Interactive Datatable Builder\n".
            "<jump-secondary>Version:</> <info>%s</info> | ".
            "<jump-secondary>PHP:</> <info>%s</info>\n",
            $this->getName(),
            $this->getVersion(),
            PHP_VERSION
        );
    }
}