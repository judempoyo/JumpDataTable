<?php

use PHPUnit\Framework\TestCase;
use Jump\JumpDataTable\Action;

class ActionTest extends TestCase
{
    public function testViewAction()
    {
        $action = Action::view('View', fn() => '/view/1');
        $this->assertEquals('view', $action['type']);
        $this->assertEquals('/view/1', $action['url']());
    }

    public function testEditAction()
    {
        $action = Action::edit('Edit', fn() => '/edit/1');
        $this->assertEquals('edit', $action['type']);
        $this->assertEquals('/edit/1', $action['url']());
    }

    public function testDeleteAction()
    {
        $action = Action::delete('Delete', fn() => '/delete/1');
        $this->assertEquals('delete', $action['type']);
        $this->assertEquals('/delete/1', $action['url']());
    }
}