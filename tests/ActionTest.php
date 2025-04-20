<?php

use PHPUnit\Framework\TestCase;
use Jump\JumpDataTable\Action;

class ActionTest extends TestCase
{
    public function testViewAction()
    {
        $action = Action::view('View', fn() => '/view/1');
        $this->assertEquals('view', $action['type']);
        $this->assertEquals('View', $action['label']);
        $this->assertEquals('/view/1', $action['url']());
    }

    public function testEditAction()
    {
        $action = Action::edit('Edit', fn() => '/edit/1');
        $this->assertEquals('edit', $action['type']);
        $this->assertEquals('Edit', $action['label']);
        $this->assertEquals('/edit/1', $action['url']());
    }

    public function testDeleteAction()
    {
        $action = Action::delete('Delete', fn() => '/delete/1');
        $this->assertEquals('delete', $action['type']);
        $this->assertEquals('Delete', $action['label']);
        $this->assertEquals('/delete/1', $action['url']());
    }

    public function testCustomAction()
    {
        $action = Action::custom('Custom', fn() => '/custom/1', fn() => '<svg>...</svg>');
        $this->assertEquals('custom', $action['type']);
        $this->assertEquals('Custom', $action['label']);
        $this->assertEquals('/custom/1', $action['url']());
        $this->assertEquals('<svg>...</svg>', $action['icon']);
    }
}