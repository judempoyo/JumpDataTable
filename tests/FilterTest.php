<?php

namespace Jump\JumpDataTable\Tests;

use Jump\JumpDataTable\Filter;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{
    public function testBasicFilterCreation()
    {
        $filter = new Filter('name', 'Name');
        
        $this->assertEquals('name', $filter->getName());
        $this->assertEquals('Name', $filter->getLabel());
        $this->assertEquals('text', $filter->getType());
        $this->assertNull($filter->getValue());
    }

    public function testFilterTypes()
    {
        $textFilter = Filter::text('search', 'Search');
        $selectFilter = Filter::select('status', 'Status', ['active' => 'Active']);
        $dateFilter = Filter::date('created_at', 'Created At');
        
        $this->assertEquals('text', $textFilter->getType());
        $this->assertEquals('select', $selectFilter->getType());
        $this->assertEquals('date', $dateFilter->getType());
        $this->assertEquals(['active' => 'Active'], $selectFilter->getOptions());
    }

    public function testCustomFilter()
    {
        $filter = Filter::custom('price', 'Price', function($data, $value) {
            return array_filter($data, fn($item) => $item['price'] >= $value);
        });
        
        $filter->setValue(100);
        
        $data = [
            ['id' => 1, 'price' => 50],
            ['id' => 2, 'price' => 150],
            ['id' => 3, 'price' => 200]
        ];
        
        $filtered = $filter->apply($data);
        $this->assertCount(2, $filtered);
        $this->assertEquals(2, $filtered[1]['id']);
    }

    public function testValueSetting()
    {
        $filter = new Filter('active', 'Active', ['type' => 'select', 'options' => ['1' => 'Yes']]);
        $filter->setValue('1');
        
        $this->assertEquals('1', $filter->getValue());
    }

    public function testAttributes()
    {
        $filter = new Filter('email', 'Email', [
            'attributes' => ['placeholder' => 'Enter email']
        ]);
        
        $filter->addAttribute('data-test', 'value');
        
        $attrs = $filter->getAttributes();
        $this->assertEquals('Enter email', $attrs['placeholder']);
        $this->assertEquals('value', $attrs['data-test']);
    }

    public function testToArrayConversion()
    {
        $filter = new Filter('category', 'Category', [
            'type' => 'select',
            'options' => ['1' => 'Books'],
            'value' => '1'
        ]);
        
        $array = $filter->toArray();
        
        $this->assertEquals('category', $array['name']);
        $this->assertEquals('select', $array['type']);
        $this->assertEquals(['1' => 'Books'], $array['options']);
        $this->assertEquals('1', $array['value']);
    }
}