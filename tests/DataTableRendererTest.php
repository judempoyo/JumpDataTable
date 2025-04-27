<?php

namespace Jump\JumpDataTable\Tests;

use Jump\JumpDataTable\DataTable;
use Jump\JumpDataTable\DataTableRenderer;
use PHPUnit\Framework\TestCase;

class DataTableRendererTest extends TestCase
{
    public function testRendererInitialization()
    {
        $renderer = new DataTableRenderer('tailwind');
        $this->assertInstanceOf(DataTableRenderer::class, $renderer);
    }

    public function testThemeClassesGeneration()
    {
        $renderer = new DataTableRenderer('tailwind');
        $table = DataTable::make()
            ->title('Test')
            ->setColumns([['key' => 'id', 'label' => 'ID']]);
            
        $output = $renderer->render($table->toArray());
        
        $this->assertStringContainsString('Test', $output);
        $this->assertStringContainsString('ID', $output);
    }

    public function testDarkModeClasses()
    {
        $renderer = new DataTableRenderer('tailwind');
        $table = DataTable::make()
            ->setThemeMode('dark')
            ->setColumns([['key' => 'name', 'label' => 'Name']]);
            
        $output = $renderer->render($table->toArray());
        $this->assertStringContainsString('bg-gray-800', $output);
    }

    public function testInvalidThemeHandling()
    {
        $this->expectException(\InvalidArgumentException::class);
        new DataTableRenderer('invalid-theme');
    }

    public function testCustomViewsPath()
    {
        $customPath = __DIR__.'/../resources/views'; // Vous devriez créer ce répertoire pour le test
        $renderer = new DataTableRenderer('tailwind', $customPath);
        
        // Cette partie dépend de votre implémentation réelle
        // Vous pourriez vouloir tester que le chemin est correctement utilisé
        $this->assertStringContainsString($customPath, $renderer->getViewPath());
    }
}