<?php
namespace HakimCh\Form\Tests;

use \HakimCh\Form\Form;
use Mockery\Loader;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__DIR__).DS);

require ROOT.'vendor/autoload.php';

$loader = new Loader();
$loader->register();

$_SERVER['REQUEST_METHOD'] = 'POST';

class FormTest extends \PHPUnit_Framework_TestCase
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
        $this->assertEquals('myFormId', $form->get('id', 'attrs'));
    }

    public function testAddAttr_WidthArrayValue_ReturnTrue()
    {
        $form = new Form();
        $form->addAttr(['id'=>'myFormId', 'name'=>'myFormName']);
        $this->assertEquals('myFormName', $form->get('name', 'attrs'));
    }

    public function testAddClass()
    {
        $form = new Form();
        $form->addClass('myClassName');
        $this->assertEquals(['myClassName'], $form->classes);
    }

    public function testUsedFor()
    {
        $form = new Form();
        $form->usedFor('upload');
        $this->assertEquals(['enctype'=>'multipart/form-data'], $form->attrs);
    }

    public function testGenerateAttrs()
    {
        $form = new Form();
        $form->addClass('myClassName')
             ->addClass('mySecondClass')
             ->addAttr(['id'=>'myFormId', 'name'=>'myFormName']);
        $exposedMethod = $this->makePublic($form, 'generateAttrs');
        $this->assertEquals('class="myClassName mySecondClass" id="myFormId" name="myFormName" ', $exposedMethod->invoke($form));
    }

    private function makePublic($object, $method){
        $reflectedMethod = new \ReflectionMethod($object, $method);
        $reflectedMethod->setAccessible(true);
        return $reflectedMethod;        
    }
}