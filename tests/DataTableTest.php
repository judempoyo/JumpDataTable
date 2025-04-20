<?php

use PHPUnit\Framework\TestCase;
use Jump\JumpDataTable\DataTable;

class DataTableTest extends TestCase
{
    public function testCanSetTitle()
    {
        $dataTable = DataTable::make()->title('Test Title');
        $this->assertEquals('Test Title', $dataTable->toArray()['title']);
    }

    public function testCanAddColumns()
    {
        $dataTable = DataTable::make()->addColumn(['key' => 'name', 'label' => 'Name']);
        $this->assertCount(1, $dataTable->toArray()['columns']);
    }

    public function testCanAddActions()
    {
        $dataTable = DataTable::make()->addAction(['type' => 'view', 'label' => 'View']);
        $this->assertCount(1, $dataTable->toArray()['actions']);
    }

    public function testCanAddFilters()
    {
        $dataTable = DataTable::make()->addFilter(['name' => 'search', 'label' => 'Search']);
        $this->assertCount(1, $dataTable->toArray()['filters']);
    }
}