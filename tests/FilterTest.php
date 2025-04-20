<?php

use PHPUnit\Framework\TestCase;
use Jump\JumpDataTable\Filter;

class FilterTest extends TestCase
{
    public function testCanAddAndRetrieveFilters()
    {
        $filter = new Filter();
        $filter->addFilter('status', 'active');
        $this->assertEquals(['status' => 'active'], $filter->getFilters());
    }

    public function testApplyFilters()
    {
        $filter = new Filter();
        $filter->addFilter('status', 'active');

        $data = [
            ['id' => 1, 'status' => 'active'],
            ['id' => 2, 'status' => 'inactive'],
        ];

        $filteredData = $filter->applyFilters($data);
        $this->assertCount(1, $filteredData);
        $this->assertEquals('active', $filteredData[0]['status']);
    }

    public function testClearFilters()
    {
        $filter = new Filter();
        $filter->addFilter('status', 'active');
        $filter->clearFilters();
        $this->assertEmpty($filter->getFilters());
    }
}