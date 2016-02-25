# Form Class
A simple html form generator class for PHP 5.4+.

## Example for starting a form
````php
$form = new HakimCh\Form\Form(); or HakimCh\Form\Form::init();
$form->addAttr('id', 'Form') // Adding attr
    ->addClass('formClass') // adding a class
    ->usedFor('upload') // If you want use it for upload some files
    ->open();

// you can add fields here

$form->close(); // Closing form
````
## Add text field
You can add many field type as (text,password,date,time,file,hidden,textarea)
````php
// Create label(name, for, required)
// Required arg will add <span class="required">*</span>
$form->label('firstName', 'firstName', false);
// A normal text field with a name
$form->text('firstName');

// Add a normal text width a tag ('strong', 'label', 'span', 'i')
$form->addText('My first Name', 'strong');
// Add an Advanced text field with options
$form->addAttr([
        'id' => 'secondName',
        'value' => 'Chmimo'
      ]) // add attrs by passing an array
      ->addClass('required') // adding a class name
      ->addClass('greenColor') // Append another class name
      ->text('secondName');
// Add a textarea
$form->addAttr('rows',5) // add number of rows
      ->addClass('redBorder') // adding a class name
      ->textarea('about');
````

## Add a select
It accept 2 args (name, options) options as an array with key => value
````php
$form->select('record', [1, 2, 3]);
````

## Add box field
Radio field
````php
$res->addAttr('value',1)->radio('testRadio');
$res->addText('Radio 1');
$res->addAttr('value',2)->radio('testRadio');
$res->addText('Radio 2');
````

Checkbox field
````php
$res->addAttr('value',1)->checkbox('testCheckbox[]');
$res->addText('Checkbox 1');
$res->addAttr('value',2)->checkbox('testCheckbox[]');
$res->addText('Checkbox 2');
````

## Add submit button
````php
// Accept one arg (value)
$res->addClass('btn btn-success')->submit('Send my Form');
````
