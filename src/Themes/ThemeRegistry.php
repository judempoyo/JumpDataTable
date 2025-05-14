<?php

namespace Jump\JumpDataTable\Themes;

use Symfony\Component\Finder\Finder;

class ThemeRegistry
{
    private static array $themes = [
        'tailwind' => "Jump\\JumpDataTable\\Themes\\TailwindTheme",
        'bootstrap' => "Jump\\JumpDataTable\\Themes\\BootstrapTheme"
    ];

    public static function register(string $name, string $class, ?string $filePath = null): void
    {
        if ($filePath && !class_exists($class)) {
            require_once $filePath;
        }

        if (!in_array(ThemeInterface::class, class_implements($class))) {
            throw new \InvalidArgumentException("Theme must implement ThemeInterface");
        }
        
        self::$themes[$name] = $class;
    }

    public static function discover(string $directory, string $namespacePrefix): void
    {
        $finder = new Finder();
        $finder->files()
            ->in($directory)
            ->name('*Theme.php')
            ->sortByName();

        foreach ($finder as $file) {
            $className = $namespacePrefix.'\\'.$file->getBasename('.php');
            if (class_exists($className) && in_array(ThemeInterface::class, class_implements($className))) {
                $themeName = strtolower(str_replace('Theme', '', $file->getBasename('.php')));
                self::register($themeName, $className);
            }
        }
    }

    public static function get(string $name): string
    {
        if (!isset(self::$themes[$name])) {
            $available = array_map(
                fn($k) => "<comment>$k</comment>", 
                array_keys(self::$themes)
            );
            
            throw new \InvalidArgumentException(sprintf(
                "Theme '%s' not registered. Available themes:\n%s",
                $name,
                implode(', ', $available)
            ));
        }
        
        return self::$themes[$name];
    }

    public static function all(): array
    {
        return self::$themes;
    }

    public static function isRegistered(string $name): bool
    {
        return isset(self::$themes[$name]);
    }
}