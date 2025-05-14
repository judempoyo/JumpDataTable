<?php

namespace Jump\JumpDataTable\Themes;

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

    public static function get(string $name): string
    {
        if (!isset(self::$themes[$name])) {
            throw new \InvalidArgumentException(sprintf(
                "Theme '%s' not registered. Available: %s",
                $name,
                implode(', ', array_keys(self::$themes))
            ));
        }
        
        return self::$themes[$name];
    }

    public static function all(): array
    {
        return self::$themes;
    }
}