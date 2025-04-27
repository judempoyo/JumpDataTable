<?php

namespace Jump\JumpDataTable\Tests;

use Jump\JumpDataTable\DataAction;
use PHPUnit\Framework\TestCase;

class DataActionTest extends TestCase
{
    public function testBasicActionCreation()
    {
        $action = new DataAction('view', 'View', fn($item) => '/view/'.$item['id']);
        
        $this->assertEquals('view', $action->getType());
        $this->assertEquals('View', $action->getLabel());
        $this->assertEquals('/view/123', $action->getUrl(['id' => 123]));
        $this->assertTrue($action->isEnabled());
    }

    public function testFromArrayCreation()
    {
        $action = DataAction::fromArray([
            'type' => 'edit',
            'label' => 'Edit',
            'url' => fn($item) => '/edit/'.$item['id'],
            'icon' => '<svg>edit</svg>',
            'class' => 'btn btn-primary',
            'enabled' => false
        ]);
        
        $this->assertEquals('edit', $action->getType());
        $this->assertEquals('Edit', $action->getLabel());
        $this->assertEquals('/edit/456', $action->getUrl(['id' => 456]));
        $this->assertEquals('<svg>edit</svg>', $action->getIcon());
        $this->assertContains('btn', $action->getClasses());
        $this->assertContains('btn-primary', $action->getClasses());
        $this->assertFalse($action->isEnabled());
    }

    public function testPredefinedActions()
    {
        $viewAction = DataAction::view('View Item', fn($item) => '/view/'.$item['id']);
        $editAction = DataAction::edit('Edit Item', fn($item) => '/edit/'.$item['id']);
        $deleteAction = DataAction::delete('Delete Item', fn($item) => '/delete/'.$item['id']);
        
        $this->assertEquals('view', $viewAction->getType());
        $this->assertEquals('edit', $editAction->getType());
        $this->assertEquals('delete', $deleteAction->getType());
        
        $this->assertStringContainsString('svg', $viewAction->getIcon());
        $this->assertStringContainsString('svg', $editAction->getIcon());
        $this->assertStringContainsString('svg', $deleteAction->getIcon());
    }

    public function testActionModification()
    {
        $action = new DataAction('custom', 'Custom', fn() => '#');
        
        $action->setIcon('<i>icon</i>')
               ->setOptions(['confirm' => 'Are you sure?'])
               ->addClass('extra-class')
               ->setEnabled(false);
               
        $this->assertEquals('<i>icon</i>', $action->getIcon());
        $this->assertEquals(['confirm' => 'Are you sure?'], $action->getOptions());
        $this->assertContains('extra-class', $action->getClasses());
        $this->assertFalse($action->isEnabled());
    }

    public function testToArrayConversion()
    {
        $action = new DataAction('download', 'Download', fn($item) => '/download/'.$item['id']);
        $action->setIcon('<svg>download</svg>')
               ->addClass('btn')
               ->addClass('btn-success');
               
        $array = $action->toArray();
        
        $this->assertEquals('download', $array['type']);
        $this->assertEquals('Download', $array['label']);
        $this->assertEquals('<svg>download</svg>', $array['icon']);
        $this->assertStringContainsString('btn btn-success', $array['class']);
    }
}