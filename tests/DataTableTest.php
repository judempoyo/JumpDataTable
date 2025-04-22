<?php

use PHPUnit\Framework\TestCase;
use Jump\JumpDataTable\DataTable;
use Jump\JumpDataTable\DataTableRenderer;
use Jump\JumpDataTable\Themes\TailwindTheme;

class DataTableTest extends TestCase
{
    public function testSetTitle()
    {
        $table = new DataTable();
        $result = $table->title('My Table');
        
        $this->assertEquals('My Table', $table->toArray()['title']);
        $this->assertSame($table, $result);
    }

    public function testSetColumns()
    {
        $table = new DataTable();
        $columns = [['key' => 'id', 'label' => 'ID']];
        $result = $table->columns($columns);
        
        $this->assertEquals($columns, $table->toArray()['columns']);
        $this->assertSame($table, $result);
    }

    public function testAddColumn()
    {
        $table = new DataTable();
        $column = ['key' => 'name', 'label' => 'Nom'];
        $result = $table->addColumn($column);
        
        $this->assertEquals([$column], $table->toArray()['columns']);
        $this->assertSame($table, $result);
    }

    public function testUseTheme()
    {
        $table = new DataTable();
        $result = $table->useTheme('tailwind', ['custom' => 'config']);
        
        $this->assertEquals('tailwind', $table->theme);
        $this->assertArrayHasKey('custom', $table->config);
        $this->assertSame($table, $result);
    }

    public function testUseInvalidThemeThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        $table = new DataTable();
        $table->useTheme('invalid-theme');
    }

    public function testRender()
    {
        $table = new DataTable();
        $table->title('Test Table')
              ->columns([['key' => 'id', 'label' => 'ID']])
              ->data([['id' => 1], ['id' => 2]]);
        
        // Mock du renderer
        $mockRenderer = $this->createMock(DataTableRenderer::class);
        $mockRenderer->method('render')
                    ->willReturn('<table>Test Table</table>');
        
        // On injecte le mock (vous devrez adapter votre classe pour permettre cette injection)
        $reflection = new \ReflectionClass($table);
        $property = $reflection->getProperty('theme');
        $property->setAccessible(true);
        $property->setValue($table, 'tailwind');
        
        $html = $table->render();
        
        $this->assertIsString($html);
        $this->assertStringContainsString('<table', $html);
        $this->assertStringContainsString('Test Table', $html);
    }

    public function testToArray()
    {
        $table = new DataTable();
        $table->title('Test')
              ->columns([['key' => 'id']])
              ->data([['id' => 1]])
              ->actions(['edit'])
              ->filters(['status']);
        
        $array = $table->toArray();
        
        $this->assertIsArray($array);
        $this->assertArrayHasKey('title', $array);
        $this->assertArrayHasKey('columns', $array);
        $this->assertArrayHasKey('data', $array);
        $this->assertArrayHasKey('actions', $array);
        $this->assertArrayHasKey('filters', $array);
    }
}