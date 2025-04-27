<?php

namespace Jump\JumpDataTable\Tests;

use Jump\JumpDataTable\DataColumn;
use PHPUnit\Framework\TestCase;

class DataColumnTest extends TestCase
{
    public function testBasicColumnCreation()
    {
        $column = new DataColumn('name', 'Name');
        
        $this->assertEquals('name', $column->getKey());
        $this->assertEquals('Name', $column->getLabel());
        $this->assertFalse($column->isSortable());
        $this->assertFalse($column->isSearchable());
        $this->assertTrue($column->isVisible());
    }

    public function testFromArrayCreation()
    {
        $column = DataColumn::fromArray([
            'key' => 'email',
            'label' => 'Email Address',
            'sortable' => true,
            'searchable' => true,
            'visible' => false,
            'width' => '200px',
            'class' => 'text-blue-500'
        ]);
        
        $this->assertEquals('email', $column->getKey());
        $this->assertEquals('Email Address', $column->getLabel());
        $this->assertTrue($column->isSortable());
        $this->assertTrue($column->isSearchable());
        $this->assertFalse($column->isVisible());
        $this->assertContains('text-blue-500', $column->getClasses());
    }

    public function testFormats()
    {
        $dateColumn = (new DataColumn('created_at', 'Created At'))->asDate('Y-m-d');
        $boolColumn = (new DataColumn('active', 'Active'))->asBoolean();
        $statusColumn = (new DataColumn('status', 'Status'))
            ->withStatuses([
                'pending' => 'bg-yellow-100 text-yellow-800',
                'approved' => 'bg-green-100 text-green-800'
            ]);
            
        $this->assertEquals('date', $dateColumn->getFormat());
        $this->assertEquals('boolean', $boolColumn->getFormat());
        $this->assertEquals('status', $statusColumn->getFormat());
    }

    public function testCustomRenderer()
    {
        $column = (new DataColumn('price', 'Price'))
            ->withRenderer(function($item) {
                return '$'.number_format($item['price'], 2);
            });
            
        $rendered = $column->renderValue(['price' => 19.99]);
        $this->assertEquals('$19.99', $rendered);
    }

    public function testToArrayConversion()
    {
        $column = (new DataColumn('quantity', 'Qty'))
            ->sortable()
            ->searchable()
            ->width('100px')
            ->addClass('text-right');
            
        $array = $column->toArray();
        
        $this->assertEquals('quantity', $array['key']);
        $this->assertEquals('Qty', $array['label']);
        $this->assertTrue($array['sortable']);
        $this->assertTrue($array['searchable']);
        $this->assertEquals('100px', $array['width']);
        $this->assertStringContainsString('text-right', $array['class']);
    }
}