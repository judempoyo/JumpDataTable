<?php
namespace Jump\JumpDataTable\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(
    name: 'make:datatable-theme',
    description: 'Create a custom theme for JumpDataTable'
)]
class MakeThemeCommand extends Command
{
    protected function configure()
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'Theme name')
            ->addOption(
                'dir', 
                'd', 
                InputOption::VALUE_REQUIRED, 
                'Target directory',
                'src/DataTable/Themes'
            )
            ->addOption(
                'namespace', 
                null, 
                InputOption::VALUE_REQUIRED, 
                'PHP namespace',
                'App\\DataTable\\Themes'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filesystem = new Filesystem();

        $name = $input->getArgument('name');
        $targetDir = $input->getOption('dir');
        $namespace = $input->getOption('namespace');

        $className = ucfirst($name).'Theme';
        $fullPath = "$targetDir/$className.php";

        if ($filesystem->exists($fullPath)) {
            $io->error("Theme $className already exists!");
            return Command::FAILURE;
        }

        $filesystem->mkdir($targetDir);
        $filesystem->dumpFile($fullPath, $this->generateTemplate($namespace, $className));

        $io->success("Theme created successfully!");
        $io->text([
            "Next steps:",
            "",
            "1. Register your theme in your application bootstrap:",
            sprintf("ThemeRegistry::register('%s', %s\\%s::class, __DIR__.'/../%s');", 
                strtolower($name), 
                $namespace, 
                $className,
                $fullPath
            ),
            "",
            "2. Use it in your code:",
            sprintf("new DataTableRenderer('%s')", strtolower($name))
        ]);

        return Command::SUCCESS;
    }

    private function generateTemplate(string $namespace, string $className): string
    {
        return <<<EOT
<?php

namespace {$namespace};

use Jump\JumpDataTable\Themes\ThemeInterface;

class {$className} implements ThemeInterface
{
    protected static array \$presets = [];
    protected static array \$currentPreset = [];
    protected static array \$customConfig = [];

    public static function getDefaultConfig(): array
    {
        return [
            'containerClass' => 'container-classes',
            'titleClass' => 'text-2xl font-bold',
            // Ajoutez toutes les configurations nécessaires
        ];
    }

    // Implémentez toutes les méthodes de ThemeInterface
    // Voici quelques exemples :

    public static function getContainerClasses(): string
    {
        return self::getConfigValue('containerClass');
    }

    public static function getTitleClasses(): string
    {
        return self::getConfigValue('titleClass');
    }

    protected static function getConfigValue(string \$key, \$default = "")
    {
        return self::\$customConfig[\$key] 
            ?? self::\$currentPreset[\$key] 
            ?? self::getDefaultConfig()[\$key] 
            ?? \$default;
    }

    // ... autres méthodes requises par l'interface
}
EOT;
    }
}