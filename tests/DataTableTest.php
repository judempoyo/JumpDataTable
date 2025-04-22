<?php

namespace Tests\Jump\JumpDataTable;

use PHPUnit\Framework\TestCase;
use Jump\JumpDataTable\DataTable;
use Jump\JumpDataTable\DataTableRenderer;
use Jump\JumpDataTable\Themes\TailwindTheme;
use InvalidArgumentException;

class DataTableTest extends TestCase
{
    private DataTable $table;

    protected function setUp(): void
    {
        $this->table = new DataTable();
    }

    public function testInitialState()
    {
        $this->assertEquals('Liste des éléments', $this->table->toArray()['title']);
        $this->assertEquals('#', $this->table->toArray()['createUrl']);
        $this->assertEmpty($this->table->toArray()['columns']);
        $this->assertNull($this->table->toArray()['data']);
        $this->assertTrue($this->table->toArray()['showExport']);
    }

    public function testMakeStaticConstructor()
    {
        $table = DataTable::make();
        $this->assertInstanceOf(DataTable::class, $table);
    }

    public function testTitle()
    {
        $result = $this->table->title('My Table');
        $this->assertEquals('My Table', $this->table->toArray()['title']);
        $this->assertSame($this->table, $result);
    }

    public function testCreateUrl()
    {
        $result = $this->table->createUrl('/create');
        $this->assertEquals('/create', $this->table->toArray()['createUrl']);
        $this->assertSame($this->table, $result);
    }

    public function testColumns()
    {
        $columns = [['key' => 'id', 'label' => 'ID']];
        $result = $this->table->columns($columns);
        $this->assertEquals($columns, $this->table->toArray()['columns']);
        $this->assertSame($this->table, $result);
    }

    public function testAddColumn()
    {
        $column = ['key' => 'name', 'label' => 'Name'];
        $result = $this->table->addColumn($column);
        $this->assertEquals([$column], $this->table->toArray()['columns']);
        $this->assertSame($this->table, $result);
    }

    public function testData()
    {
        $data = [['id' => 1, 'name' => 'Test']];
        $result = $this->table->data($data);
        $this->assertEquals($data, $this->table->toArray()['data']);
        $this->assertSame($this->table, $result);
    }

    public function testActions()
    {
        $actions = ['edit', 'delete'];
        $result = $this->table->actions($actions);
        $this->assertEquals($actions, $this->table->toArray()['actions']);
        $this->assertSame($this->table, $result);
    }

    public function testAddAction()
    {
        $action = ['view'];
        $result = $this->table->addAction($action);
        $this->assertEquals([$action], $this->table->toArray()['actions']);
        $this->assertSame($this->table, $result);
    }

    public function testFilters()
    {
        $filters = ['status' => 'active'];
        $result = $this->table->filters($filters);
        $this->assertEquals($filters, $this->table->toArray()['filters']);
        $this->assertSame($this->table, $result);
    }

    public function testAddFilter()
    {
        $filter = ['category' => 'books'];
        $result = $this->table->addFilter($filter);
        $this->assertEquals([$filter], $this->table->toArray()['filters']);
        $this->assertSame($this->table, $result);
    }

    public function testModelName()
    {
        $result = $this->table->modelName('Product');
        $this->assertEquals('Product', $this->table->toArray()['modelName']);
        $this->assertSame($this->table, $result);
    }

    public function testShowExport()
    {
        $result = $this->table->showExport(false);
        $this->assertFalse($this->table->toArray()['showExport']);
        $this->assertSame($this->table, $result);
    }

    public function testSort()
    {
        $result = $this->table->sort('name');
        $this->assertEquals('name', $this->table->toArray()['sort']);
        $this->assertSame($this->table, $result);
    }

    public function testDirection()
    {
        $result = $this->table->direction('desc');
        $this->assertEquals('desc', $this->table->toArray()['direction']);
        $this->assertSame($this->table, $result);
    }

    public function testPublicUrl()
    {
        $result = $this->table->publicUrl('/public');
        $this->assertEquals('/public', $this->table->toArray()['publicUrl']);
        $this->assertSame($this->table, $result);
    }

    public function testPagination()
    {
        $pagination = ['perPage' => 10];
        $result = $this->table->pagination($pagination);
        $this->assertEquals($pagination, $this->table->toArray()['pagination']);
        $this->assertSame($this->table, $result);
    }

    public function testUseTheme()
    {
        $result = $this->table->useTheme('tailwind', ['custom' => 'config']);
        
        // Utilisation de la réflexion pour vérifier la propriété protégée
        $reflection = new \ReflectionClass($this->table);
        $themeProperty = $reflection->getProperty('theme');
        $themeProperty->setAccessible(true);
        $themeValue = $themeProperty->getValue($this->table);
        
        $configProperty = $reflection->getProperty('config');
        $configProperty->setAccessible(true);
        $configValue = $configProperty->getValue($this->table);
        
        $this->assertEquals('tailwind', $themeValue);
        $this->assertArrayHasKey('custom', $configValue);
        $this->assertSame($this->table, $result);
    }


    public function testHasTheme()
    {
        $this->assertTrue($this->table->hasTheme('tailwind'));
        $this->assertTrue($this->table->hasTheme('bootstrap'));
        $this->assertFalse($this->table->hasTheme('invalid-theme'));
    }

    public function testUseInvalidThemeThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Thème invalid-theme non supporté');
        $this->table->useTheme('invalid-theme');
    }


    public function testToArray()
    {
        // Configurez d'abord le tableau avec des valeurs spécifiques
        $this->table->title('Test')
              ->columns([['key' => 'id']])
              ->data([['id' => 1]])
              ->actions(['edit'])
              ->filters(['status']);
        
        $expected = [
            'title' => 'Test',
            'createUrl' => '#',
            'columns' => [['key' => 'id']],
            'data' => [['id' => 1]],
            'actions' => ['edit'],
            'filters' => ['status'],
            'modelName' => 'default',
            'showExport' => true,
            'sort' => '',
            'direction' => 'asc',
            'publicUrl' => '/',
            'pagination' => [],
        ];
        
        $this->assertEquals($expected, $this->table->toArray());
    }

    public function testRender()
    {
        // Mock complet du renderer et de sa dépendance
        $mockRenderer = $this->getMockBuilder(DataTableRenderer::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['render'])
            ->getMock();
        
        $mockRenderer->expects($this->once())
            ->method('render')
            ->willReturn('<table><tr><td>Test</td></tr></table>');
        
        // Utilisation de la réflexion pour injecter le mock
        $reflection = new \ReflectionClass($this->table);
        
        // Injecter le thème
        $themeProperty = $reflection->getProperty('theme');
        $themeProperty->setAccessible(true);
        $themeProperty->setValue($this->table, 'tailwind');
        
        // Remplacer le renderer par le mock
        $rendererProperty = $reflection->getProperty('renderer');
        $rendererProperty->setAccessible(true);
        $rendererProperty->setValue($this->table, $mockRenderer);
        
        // Configurer des données minimales
        $this->table->columns([['key' => 'id', 'label' => 'ID']]);
        
        $html = $this->table->render();
        
        $this->assertIsString($html);
        $this->assertStringContainsString('<table>', $html);
        $this->assertStringContainsString('</table>', $html);
    }
}