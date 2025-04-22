<?php

namespace Tests\Jump\JumpDataTable;

use PHPUnit\Framework\TestCase;
use Jump\JumpDataTable\DataTableRenderer;
use InvalidArgumentException;

class DataTableRendererTest extends TestCase
{
    public function testConstructorWithValidTheme()
    {
        $renderer = new DataTableRenderer('tailwind');
        $this->assertInstanceOf(DataTableRenderer::class, $renderer);
        
        // Vérification via la méthode helper
        $this->assertEquals('tailwind', $this->getPrivateProperty($renderer, 'theme'));
        $this->assertEquals(
            'Jump\\JumpDataTable\\Themes\\TailwindTheme',
            $this->getPrivateProperty($renderer, 'themeClass')
        );
    }

    public function testConstructorWithInvalidTheme()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Theme invalid-theme is not supported');
        new DataTableRenderer('invalid-theme');
    }

    public function testRenderWithLightTheme()
    {
        $renderer = new DataTableRenderer('tailwind');
        
        // Configuration minimale pour le rendu
        $config = [
            'theme' => 'light',
            'title' => 'Test Table',
            'columns' => [['key' => 'id', 'label' => 'ID']],
            'data' => [['id' => 1]],
            'createUrl' => '#',
            'modelName' => 'test'
        ];
        
        $html = $renderer->render($config);

        $this->assertIsString($html);
        $this->assertStringContainsString('<table', $html);
        $this->assertStringContainsString('Test Table', $html);
        $this->assertStringContainsString('bg-white', $html); // Classe light theme
    }

    public function testRenderWithDarkTheme()
    {
        $renderer = new DataTableRenderer('tailwind');
        
        $config = [
            'theme' => 'dark',
            'title' => 'Test Table',
            'columns' => [['key' => 'id', 'label' => 'ID']]
        ];
        
        $html = $renderer->render($config);

        $this->assertIsString($html);
        $this->assertStringContainsString('<table', $html);
        $this->assertStringContainsString('dark:bg-dark-800', $html); // Classe dark theme
    }

    public function testRenderWithMockedView()
    {
        // Création d'un mock pour le renderer
        $renderer = $this->getMockBuilder(DataTableRenderer::class)
            ->setConstructorArgs(['tailwind'])
            ->onlyMethods(['getViewPath'])
            ->getMock();

        // Mock du chemin de vue pour retourner un fichier de test simple
        $renderer->method('getViewPath')
            ->willReturn(__DIR__.'/../test_view.php');

        // Création d'un fichier de vue de test temporaire
        file_put_contents(__DIR__.'/../test_view.php', '<?php echo "TEST RENDER: ".$title; ?>');

        $html = $renderer->render(['title' => 'Mocked Title']);

        $this->assertEquals('TEST RENDER: Mocked Title', $html);

        // Nettoyage
        unlink(__DIR__.'/../test_view.php');
    }

    public function testGenerateThemeClasses()
    {
        $renderer = new DataTableRenderer('tailwind');
        $method = new \ReflectionMethod($renderer, 'generateThemeClasses');
        $method->setAccessible(true);

        $classes = $method->invoke($renderer, false); // light theme
        $this->assertIsArray($classes);
        $this->assertArrayHasKey('container', $classes);
        $this->assertStringContainsString('bg-white', $classes['container']);
    }

    public function testGetViewPath()
    {
        $renderer = new DataTableRenderer('tailwind');
        $method = new \ReflectionMethod($renderer, 'getViewPath');
        $method->setAccessible(true);

        $viewPath = $method->invoke($renderer);
        $this->assertStringEndsWith('Tailwind/table.php', $viewPath);
        $this->assertFileExists($viewPath);
    }

    /**
     * Helper method to access private/protected properties.
     */
    private function getPrivateProperty(object $object, string $property)
    {
        $reflection = new \ReflectionClass($object);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);
        return $property->getValue($object);
    }
}