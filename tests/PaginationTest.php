<?php

namespace Jump\JumpDataTable\Tests;

use Jump\JumpDataTable\Pagination;
use PHPUnit\Framework\TestCase;

class PaginationTest extends TestCase
{
    public function testBasicPagination()
    {
        $pagination = new Pagination(100, 10, 1);
        
        $this->assertEquals(100, $pagination->getTotalItems());
        $this->assertEquals(10, $pagination->getPerPage());
        $this->assertEquals(1, $pagination->getCurrentPage());
        $this->assertEquals(10, $pagination->getLastPage());
        $this->assertEquals(0, $pagination->getOffset());
    }

    public function testPageCalculation()
    {
        $pagination = new Pagination(95, 10, 5);
        
        $this->assertEquals(10, $pagination->getLastPage());
        $this->assertEquals(40, $pagination->getOffset());
    }

    public function testLinkGeneration()
    {
        $pagination = new Pagination(50, 5, 3, '/items', ['sort' => 'name']);
        
        $links = $pagination->getLinks();
        $this->assertCount(5, $links); // Previous, 1, 2, 3, 4, 5, Next
        
        // Test previous link
        $this->assertEquals('&lsaquo;', $links[0]['label']);
        $this->assertStringContainsString('page=2', $links[0]['url']);
        
        // Test current page
        $this->assertEquals('3', $links[2]['label']);
        $this->assertTrue($links[2]['active']);
        
        // Test next link
        $this->assertEquals('&rsaquo;', $links[4]['label']);
        $this->assertStringContainsString('page=4', $links[4]['url']);
    }

    public function testEdgeCases()
    {
        // Zero items
        $pagination = new Pagination(0, 10, 1);
        $this->assertEquals(1, $pagination->getLastPage());
        
        // Current page beyond last page
        $pagination = new Pagination(30, 10, 5);
        $this->assertEquals(3, $pagination->getCurrentPage());
    }

    public function testToArrayConversion()
    {
        $pagination = new Pagination(25, 5, 2, '/test');
        
        $array = $pagination->toArray();
        
        $this->assertEquals(25, $array['total']);
        $this->assertEquals(5, $array['per_page']);
        $this->assertEquals(2, $array['current_page']);
        $this->assertEquals(5, $array['last_page']);
        $this->assertEquals('/test', $array['path']);
        $this->assertIsArray($array['links']);
    }
}