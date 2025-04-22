<?php

use PHPUnit\Framework\TestCase;
use Jump\JumpDataTable\DataTableRenderer;

class DataTableRendererTest extends TestCase
{
    public function testConstructorWithValidTheme()
    {
        $renderer = new DataTableRenderer('tailwind');
        $this->assertInstanceOf(DataTableRenderer::class, $renderer);
    }

    public function testConstructorWithInvalidTheme()
    {
        $this->expectException(\InvalidArgumentException::class);
        new DataTableRenderer('invalid-theme');
    }

    public function testRender()
    {
        $renderer = new DataTableRenderer('tailwind');
        $html = $renderer->render(['theme' => 'light']);
        $this->assertIsString($html);
    }
}