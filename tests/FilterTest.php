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

    public function testHasFiltersReturnsTrueWhenFiltersAreApplied()
    {
        $filter = new Filter();
        $filter->addFilter('status', 'active');
        $this->assertTrue($filter->hasFilters());
    }

    public function testHasFiltersReturnsFalseWhenNoFiltersAreApplied()
    {
        $filter = new Filter();
        $this->assertFalse($filter->hasFilters());
    }

    public function testApplyFiltersWithEmptyData()
    {
        $filter = new Filter();
        $filter->addFilter('status', 'active');
        $data = [];
        $filteredData = $filter->applyFilters($data);
        $this->assertEmpty($filteredData);
    }

    public function testApplyFiltersWithNoMatchingFilters()
    {
        $filter = new Filter();
        $filter->addFilter('status', 'active');

        $data = [
            ['id' => 1, 'status' => 'inactive'],
            ['id' => 2, 'status' => 'inactive'],
        ];

        $filteredData = $filter->applyFilters($data);
        $this->assertEmpty($filteredData);
    }

    public function testApplyFiltersWithPartialMatchingFilters()
    {
        $filter = new Filter();
        $filter->addFilter('status', 'active');

        $data = [
            ['id' => 1, 'status' => 'active'],
            ['id' => 2, 'status' => 'inactive'],
            ['id' => 3, 'status' => 'active'],
        ];

        $filteredData = $filter->applyFilters($data);
        $this->assertCount(2, $filteredData);
        $this->assertEquals('active', $filteredData[0]['status']);
        $this->assertEquals('active', $filteredData[1]['status']);
    }
}