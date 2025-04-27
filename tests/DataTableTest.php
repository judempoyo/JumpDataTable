<?php

namespace Jump\JumpDataTable\Tests;

use Jump\JumpDataTable\DataTable;
use Jump\JumpDataTable\DataColumn;
use Jump\JumpDataTable\DataAction;
use Jump\JumpDataTable\Filter;
use Jump\JumpDataTable\Pagination;
use PHPUnit\Framework\TestCase;

class DataTableTest extends TestCase
{
    private DataTable $table;

    protected function setUp(): void
    {
        $this->table = DataTable::make()
            ->title('Test Table')
            ->modelName('product')
            ->showExport(true);
    }

    public function testBasicConfiguration()
    {
        $this->assertEquals('Test Table', $this->table->toArray()['title']);
        $this->assertEquals('product', $this->table->toArray()['modelName']);
        $this->assertTrue($this->table->toArray()['showExport']);
    }

    public function testColumnsManagement()
    {
        $this->table->setColumns([
            ['key' => 'id', 'label' => 'ID'],
            new DataColumn('name', 'Name')
        ]);
        
        $columns = $this->table->toArray()['columns'];
        $this->assertCount(2, $columns);
        $this->assertEquals('id', $columns[0]['key']);
        $this->assertEquals('Name', $columns[1]['label']);
    }

    public function testActionsManagement()
    {
        $this->table->setActions([
            DataAction::view('View', fn($item) => '/view/'.$item['id']),
            ['type' => 'edit', 'label' => 'Edit', 'url' => fn($item) => '/edit/'.$item['id']]
        ]);
        
        $actions = $this->table->toArray()['actions'];
        $this->assertCount(2, $actions);
        $this->assertEquals('view', $actions[0]['type']);
        $this->assertEquals('Edit', $actions[1]['label']);
    }

    public function testFiltersManagement()
    {
        $this->table->setFilters([
            Filter::text('search', 'Search'),
            new Filter('status', 'Status', ['type' => 'select', 'options' => ['active' => 'Active']])
        ]);
        
        $filters = $this->table->toArray()['filters'];
        $this->assertCount(2, $filters);
        $this->assertEquals('search', $filters[0]['name']);
        $this->assertEquals('select', $filters[1]['type']);
    }

    public function testPagination()
    {
        $this->table->paginate(100, 10, 2);
        $pagination = $this->table->getPagination();
        
        $this->assertEquals(100, $pagination->toArray()['total']);
        $this->assertEquals(10, $pagination->toArray()['per_page']);
        $this->assertEquals(2, $pagination->toArray()['current_page']);
    }

    public function testThemeConfiguration()
    {
        $this->table->useTheme('tailwind', [
            'containerClass' => 'custom-container'
        ]);
        
        $config = $this->table->toArray()['config'];
        $this->assertEquals('custom-container', $config['containerClass']);
    }

    public function testBulkActions()
    {
        $this->table->enableRowSelection()
            ->setBulkActions([
                DataAction::delete('Delete Selected', fn() => '#bulk-delete')
            ]);
            
        $data = $this->table->toArray();
        $this->assertTrue($data['enableRowSelection']);
        $this->assertCount(1, $data['bulkActions']);
    }

    public function testEmptyState()
    {
        $this->table->emptyStateMessage('No records found');
        $this->assertEquals('No records found', $this->table->toArray()['emptyStateMessage']);
    }
}