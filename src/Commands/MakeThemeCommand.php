<?php
namespace Jump\JumpDataTable\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;


#[AsCommand(
    name: 'make:theme',
    description: 'Create a custom color theme'
)]

class MakeThemeCommand extends Command
{
    protected static $defaultName = 'jump:datatable:create-theme';

    protected function configure()
    {
        $this
            ->setDescription('Creates a new custom theme for JumpDataTable')
            ->addArgument('theme-name', InputArgument::REQUIRED, 'The name of the theme')
            ->addArgument('namespace', InputArgument::OPTIONAL, 'The namespace for the theme', 'App\\JumpDataTable\\Themes')
            ->addArgument('target-dir', InputArgument::OPTIONAL, 'Where to create the theme', 'src/JumpDataTable/Themes');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $themeName = $input->getArgument('theme-name');
        $namespace = trim($input->getArgument('namespace'), '\\');
        $targetDir = $input->getArgument('target-dir');

        $filesystem = new Filesystem();
        $themeClassName = ucfirst($themeName) . 'Theme';
        $themeFile = $targetDir.'/'.$themeClassName.'.php';

        if ($filesystem->exists($themeFile)) {
            $output->writeln('<error>Theme already exists!</error>');
            return Command::FAILURE;
        }

        $template = $this->getThemeTemplate($namespace, $themeClassName);

        $filesystem->mkdir($targetDir);
        $filesystem->dumpFile($themeFile, $template);

        $output->writeln([
            '<info>Successfully created theme!</info>',
            '',
            '<comment>Next steps:</comment>',
            sprintf('1. Register your theme: <info>DataTableRenderer::registerTheme(\'%s\', %s\\%s::class);</info>', 
                strtolower($themeName), $namespace, $themeClassName),
            '2. Use your theme: <info>new DataTableRenderer(\''.strtolower($themeName).'\')</info>',
            ''
        ]);

        return Command::SUCCESS;
    }

    protected function getThemeTemplate(string $namespace, string $className): string
    {
        return <<<EOT
<?php

namespace {$namespace};

use Jump\JumpDataTable\Themes\ThemeInterface;

class {$className} implements ThemeInterface
{
    protected static array \$presets = [
        // Vous pouvez définir des préréglages spécifiques à ce thème ici
    ];

    protected static array \$currentPreset = [];
    protected static array \$customConfig = [];

    public static function getDefaultConfig(): array
    {
        return [
            'containerClass' => '',
            'titleClass' => '',
            // Ajoutez toutes les classes nécessaires
        ];
    }

    public static function usePreset(string \$presetName): void
    {
        if (!isset(self::\$presets[\$presetName])) {
            throw new \\InvalidArgumentException("Preset \$presetName not found.");
        }

        self::\$currentPreset = call_user_func([self::\$presets[\$presetName], 'getConfig']);
    }

    public static function overridePreset(array \$overrides): void
    {
        self::\$customConfig = array_replace_recursive(self::\$currentPreset, \$overrides);
    }

    protected static function getConfigValue(string \$key, \$default = "")
    {
        if (isset(self::\$customConfig[\$key])) {
            return self::\$customConfig[\$key];
        }

        if (isset(self::\$currentPreset[\$key])) {
            return self::\$currentPreset[\$key];
        }

        \$defaultConfig = self::getDefaultConfig();
        return \$defaultConfig[\$key] ?? \$default;
    }

    // Implémentez toutes les méthodes nécessaires de ThemeInterface
    // Voici un exemple pour une méthode :
    public static function getContainerClasses(): string
    {
        return self::getConfigValue('containerClass', 'ma-classe-par-defaut');
    }

    // ... ajoutez toutes les autres méthodes requises par ThemeInterface
}
EOT;
    }
}