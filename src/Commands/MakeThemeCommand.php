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
                'src/Themes'
            )
            ->addOption(
                'namespace', 
                null, 
                InputOption::VALUE_REQUIRED, 
                'PHP namespace',
                'App\\Themes'
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

        $viewDir = "$targetDir/views";
        $filesystem->mkdir($viewDir);
        $filesystem->dumpFile("$viewDir/table.php", $this->generateViewTemplate());

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
             'containerClass' => 'max-w-full p-6 mx-auto mt-8 bg-white dark:bg-gray-800 rounded-lg shadow-xl animate__animated animate__fadeIn',
            'titleClass' => 'text-2xl font-bold md:text-3xl animate__animated animate__fadeInLeft text-gray-900 dark:text-white',
            'countBadgeClass' => 'px-3 py-1 text-sm font-medium rounded-full text-teal-800 dark:text-teal-200 bg-teal-100 dark:bg-teal-900',
            'filterButtonClass' => 'flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600',
            'addButtonClass' => 'flex items-center gap-2 px-4 py-2 text-sm font-medium text-white rounded-lg transition-all duration-300 bg-teal-500 hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-700',
            'resetButtonClass' => 'px-4 py-2 text-sm font-medium rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600',
            'applyButtonClass' => 'px-4 py-2 text-sm font-medium text-white rounded-lg bg-teal-500 hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-700',
            'actionButtonClass' => 'p-1.5 rounded-full transition duration-200 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700',
            'filtersContainerClass' => 'p-4 mt-2 rounded-lg bg-gray-50 dark:bg-gray-700',
            'filterInputClass' => 'w-full px-3 py-2 text-sm border rounded-lg shadow-sm transition duration-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500',
            'filterLabelClass' => 'block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300',
            'tableClass' => 'min-w-full divide-y divide-gray-200 dark:divide-gray-700',
            'tableHeaderClass' => 'bg-gray-50 dark:bg-gray-800',
            'tableHeaderCellClass' => 'px-6 py-3 text-xs font-medium tracking-wider text-left uppercase text-gray-500 dark:text-gray-400',
            'tableBodyClass' => 'bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700',
            'tableRowClass' => 'transition duration-150 hover:bg-gray-50 dark:hover:bg-gray-700/50',
            'tableCellClass' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100',
            'emptyStateClass' => 'flex flex-col items-center justify-center text-gray-500 dark:text-gray-400',
            'paginationClass' => 'flex items-center space-x-1',
            'pageItemClass' => 'bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600',
            'pageLinkClass' => 'text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700',
            'animationClass' => 'animate__animated',
        ];
    }

  
    public static function usePreset(string \$presetName): void
    {
        if (!isset(self::\$presets[\$presetName])) {
            throw new \InvalidArgumentException("Preset \$presetName not found. Available: " . implode(', ', array_keys(self::\$presets)));
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
        if (empty(self::\$currentPreset)) {
            \$defaultConfig = self::getDefaultConfig();
            return \$defaultConfig[\$key] ?? \$default;
        }

        return \$default;
    }

    public static function getContainerClasses(): string
    {
        return self::getConfigValue('containerClass');
    }

    public static function getTitleClasses(): string
    {
        return self::getConfigValue('titleClass');
    }

    public static function getCountBadgeClasses(): string
    {
        return self::getConfigValue('countBadgeClass');
    }

    public static function getFilterButtonClasses(): string
    {
        return self::getConfigValue('filterButtonClass');
    }

    public static function getExportButtonClasses(): string
    {
        return self::getConfigValue('filterButtonClass');
    }

    public static function getAddButtonClasses(): string
    {
        return self::getConfigValue('addButtonClass');
    }

    public static function getResetButtonClasses(): string
    {
        return self::getConfigValue('resetButtonClass');
    }

    public static function getApplyButtonClasses(): string
    {
        return self::getConfigValue('applyButtonClass');
    }

    public static function getActionButtonClasses(): string
    {
        return self::getConfigValue('actionButtonClass');
    }

    public static function getFiltersContainerClasses(): string
    {
        return self::getConfigValue('filtersContainerClass');
    }

    public static function getFilterInputClasses(): string
    {
        return self::getConfigValue('filterInputClass');
    }

    public static function getFilterLabelClasses(): string
    {
        return self::getConfigValue('filterLabelClass');
    }

    public static function getTableClasses(): string
    {
        return self::getConfigValue('tableClass');
    }

    public static function getTableHeaderClasses(): string
    {
        return self::getConfigValue('tableHeaderClass');
    }

    public static function getTableHeaderCellClasses(): string
    {
        return self::getConfigValue('tableHeaderCellClass');
    }

    public static function getTableBodyClasses(): string
    {
        return self::getConfigValue('tableBodyClass');
    }

    public static function getTableRowClasses(): string
    {
        return self::getConfigValue('tableRowClass');
    }

    public static function getTableCellClasses(): string
    {
        return self::getConfigValue('tableCellClass');
    }

    public static function getEmptyStateClasses(): string
    {
        return self::getConfigValue('emptyStateClass');
    }

    public static function getFilterIconClasses(): string
    {
        return "w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-teal-500";
    }

    public static function getExportIconClasses(): string
    {
        return self::getFilterIconClasses();
    }

    public static function getAddIconClasses(): string
    {
        return "w-5 h-5 text-white";
    }

    public static function getPaginationClasses(): string
    {
        return self::getConfigValue('paginationClass');
    }

    public static function getPageItemClasses(bool \$active = false): string
    {
        if (\$active) {
            \$primary = self::getConfigValue('colors.primary', 'teal-500');
            return "bg-\$primary border-\$primary";
        }
        return self::getConfigValue('pageItemClass');
    }

    public static function getPageLinkClasses(bool \$active = false): string
    {
        if (\$active) {
            \$primary = self::getConfigValue('colors.primary', 'teal-500');
            return "text-white bg-\$primary border-\$primary";
        }
        return self::getConfigValue('pageLinkClass');
    }

    public static function getAnimationClasses(string \$animation = "fadeIn"): string
    {
        return "animate__animated animate__\$animation";
    }

    public static function getHeaderAnimation(): string
    {
        return 'animate__animated animate-fade-in duration-500 delay-100';
    }

    public static function getTableAnimation(): string
    {
        return 'animate__animated animate-slide-up duration-300 ease-out';
    }

    public static function getRowAnimation(): string
    {
        return 'animate__animated animate-fade-in duration-300 stagger-100';
    }

    public static function getPaginationAnimation(): string
    {
        return 'animate__animated animate-fade-in duration-400 delay-200';
    }

    public static function getFiltersAnimation(): string
    {
        return 'animate__animated animate-scale-in origin-top duration-300 ease-spring';
    }

        public static function getAvailablePresets(): array
    {
        return array_keys(self::\$presets);
    }
        public static function getViewPath(): string
    {
        return __DIR__.'/views/table.php';
    }
}
EOT;
    }
  
    private function generateViewTemplate(): string
{
    return <<<'EOT'
<div class="<?= $themeClasses['container'] ?>">
    <!-- Header Section -->
    <div class="<?= $themeClasses['filtersContainer'].' '. $themeClasses['animations']['header'] ?>">
        <h1 class="<?= $themeClasses['title'] ?>">
            <?= htmlspecialchars($title) ?>
        </h1>
        
        <!-- Add your theme-specific HTML structure here -->
    </div>

    <!-- Table Section -->
    <div class="<?= $themeClasses['animations']['table'] ?>">
        <table class="<?= $themeClasses['table'] ?>">
            <!-- Table content -->
        </table>
    </div>
</div>
EOT;

}

}