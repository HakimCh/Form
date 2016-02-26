<?php namespace HakimCh\Form\Tests;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__DIR__).DS);

require ROOT.'Form.php';

require_once 'Mockery/Loader.php';
require_once 'Hamcrest/Hamcrest.php';
$loader = new \Mockery\Loader;
$loader->register();

$_SERVER['REQUEST_METHOD'] = 'POST';

use \HakimCh\Form\Form;

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

    public function testFiles()
    {
        $form = new Form();
        $_FILES = [
            'file1' => [
                'name'     =>  'file1.txt',
                'tmp_name' =>  '/tmp/php42up23',
                'type'     =>  'text/plain',
                'size'     =>  42,
                'error'    =>  0
            ],
            'file2' => [
                'name'     =>  'file2.txt',
                'tmp_name' =>  '/tmp/phpqsdp23',
                'type'     =>  'text/plain',
                'size'     =>  22,
                'error'    =>  4
            ],
        ];
        $exposedMethod = $this->makePublic($form, 'files');
        $this->assertCount(1, $exposedMethod->invoke($form));
    }

    public function testGenerateAttrs()
    {
        $form = new Form();
        $form->addClass('myClassName')
             ->addClass('mySecondClass')
             ->addAttr(['id'=>'myFormId', 'name'=>'myFormName']);
        $exposedMethod = $this->makePublic($form, 'generateAttrs');
        $this->assertEquals(' id="myFormId" name="myFormName" class="myClassName mySecondClass"', $exposedMethod->invoke($form));
    }

    private function makePublic($object, $method){
        $reflectedMethod = new \ReflectionMethod($object, $method);
        $reflectedMethod->setAccessible(true);
        return $reflectedMethod;        
    }
}