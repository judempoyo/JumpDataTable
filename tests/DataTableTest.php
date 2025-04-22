<?php

use PHPUnit\Framework\TestCase;
use Jump\JumpDataTable\DataTable;

class DataTableTest extends TestCase
{
    public function testSetTitle()
    {
        $table = new DataTable();
        $table->title('My Table');
        $this->assertEquals('My Table', $table->toArray()['title']);
    }

    public function testSetColumns()
    {
        $table = new DataTable();
        $columns = [['key' => 'id', 'label' => 'ID']];
        $table->columns($columns);
        $this->assertEquals($columns, $table->toArray()['columns']);
    }

    public function testRender()
    {
        
        $table = new DataTable();
        $table->title('Test Table');
        $html = $table->render();
        $this->assertIsString($html);
        $this->assertStringContainsString('<table', $html); 
    }
}