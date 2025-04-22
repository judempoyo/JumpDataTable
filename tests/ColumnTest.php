<?php

use PHPUnit\Framework\TestCase;
use Jump\JumpDataTable\Column;

class ColumnTest extends TestCase
{
    public function testMake()
    {
        $column = Column::make('id', 'ID');
        $this->assertEquals(['key' => 'id', 'label' => 'ID'], $column);
    }

    public function testDate()
    {
        $column = Column::date('created_at', 'Created At');
        $this->assertEquals('date', $column['format']);
    }

    public function testBoolean()
    {
        $column = Column::boolean('is_active', 'Active');
        $this->assertEquals('boolean', $column['format']);
    }
}