<?php
namespace HakimCh\Form\Tests;

require dirname(__DIR__).'/vendor/autoload.php';

use \PHPUnit_Framework_TestCase;
use \HakimCh\Form\Form;
use Mockery\Loader;

$loader = new Loader();
$loader->register();

class FormTest extends PHPUnit_Framework_TestCase
{
    public function teardown() {
        \Mockery::close();
    }

    public function testOpen()
    {
        $form     = new Form();
        $actual   = $form->open('post', 'index.php');
        $excepted = '<form action="index.php" method="post">';
        $this->assertEquals($excepted, $actual);
    }

    public function testInput_WithName_ReturnInputTag()
    {
        $mock = \Mockery::mock('Form');
        $mock->shouldReceive('text')
             ->with('email')
             ->andReturn('<input type="text" name="email">');
        $actual   = $mock->text('email');
        $excepted = '<input type="text" name="email">';
        $this->assertEquals($excepted, $actual);
    }

    public function testAddAttr_WidthSingleValue_ReturnTrue()
    {
        $form = new Form();
        $form->addAttr('id', 'myFormId');
        $this->assertEquals('myFormId', $form->get('id', 'attributes'));
    }

    public function testAddAttr_WidthArrayValue_ReturnTrue()
    {
        $form = new Form();
        $form->addAttr(['id'=>'myFormId', 'name'=>'myFormName']);
        $this->assertEquals('myFormName', $form->get('name', 'attributes'));
    }

    public function testAttributesToHtml()
    {
        $form = new Form();
        $form->addAttr('class', 'myClassName mySecondClass')
             ->addAttr(['id'=>'myFormId', 'name'=>'myFormName']);
        $exposedMethod = $this->makePublic($form, 'attributesToHtml');
        $this->assertEquals('class="myClassName mySecondClass" id="myFormId" name="myFormName" ', $exposedMethod->invoke($form));
    }

    private function makePublic($object, $method){
        $reflectedMethod = new \ReflectionMethod($object, $method);
        $reflectedMethod->setAccessible(true);
        return $reflectedMethod;        
    }
}
