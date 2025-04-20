<?php

use PHPUnit\Framework\TestCase;
use Jump\JumpDataTable\Column;

class ColumnTest extends TestCase
{
    public function testMakeColumn()
    {
        $column = Column::make('name', 'Name');
        $this->assertEquals('name', $column['key']);
        $this->assertEquals('Name', $column['label']);
    }

    public function testDateColumn()
    {
        $column = Column::date('created_at', 'Created At', 'Y-m-d');
        $this->assertEquals('date', $column['format']);
        $this->assertEquals('Y-m-d', $column['dateFormat']);
    }

    public function testBooleanColumn()
    {
        $column = Column::boolean('is_active', 'Active');
        $this->assertEquals('boolean', $column['format']);
        $this->assertArrayHasKey('true', $column['icons']);
        $this->assertArrayHasKey('false', $column['icons']);
    }

    public function testCustomColumn()
    {
        $column = Column::custom('actions', 'Actions', fn($item) => '<a href="/edit/' . $item['id'] . '">Edit</a>');
        $this->assertEquals('actions', $column['key']);
        $this->assertIsCallable($column['render']);
    }
}