<?php

use PHPUnit\Framework\TestCase;
use Jump\JumpDataTable\DataTableRenderer;

class DataTableRendererTest extends TestCase
{
    public function testRenderThrowsExceptionForMissingView()
    {
        $this->expectException(\RuntimeException::class);
        $renderer = new DataTableRenderer('/invalid/path/to/view.php');
        $renderer->render([]);
    }

      public function testRenderOutputsHtml()
    {
        $renderer = new DataTableRenderer(__DIR__ . '/../src/Resources/views/table.php');
        $output = $renderer->render([
            'title' => 'Test Table',
            'data' => [],
            'columns' => [['key' => 'name', 'label' => 'Name']],
            'actions' => [],
            'publicUrl' => '/test-url/', // Provide a publicUrl value
        ]);
        $this->assertStringContainsString('<title>Test Table</title>', $output);
    }
}