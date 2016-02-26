# Form Class
A simple html form generator class

# Install via composer
````code
composer require 'hakimch/form'
````

# Initialize the form
````php
$form = new HakimCh\Form\Form(); or HakimCh\Form\Form::init();
echo $form->addAttr('id', 'Form') // Adding attr Id
    ->addClass('formClass') // adding a class
    ->usedFor('upload') // If you want use it for upload some files
    ->open();

// you can add fields here

echo $form->close(); // Closing form
````
## Add text field
You can add many field type as (text,password,date,time,file,hidden,textarea)
````php
// Create label(name, for, required)
// Required arg will add <span class="required">*</span>
echo $form->label('firstName', 'firstName', false);
// A normal text field with a name
echo $form->text('firstName');

// Add a normal text width a tag ('strong', 'label', 'span', 'i')
echo $form->addText('My first Name', 'strong');
// Add an Advanced text field with options
echo $form->addAttr([
        'id' => 'secondName',
        'value' => 'Chmimo'
      ]) // add attrs by passing an array
      ->addClass('required') // adding a class name
      ->addClass('greenColor') // Append another class name
      ->text('secondName');
// Add a textarea
echo $form->addAttr('rows',5) // add number of rows
      ->addClass('redBorder') // adding a class name
      ->textarea('about');
````

## Add a select
It accept 2 args (name, options) options as an array with key => value
````php
echo $form->select('record', [1, 2, 3]);
````

## Add box field
Radio field
````php
echo $form->addAttr('value',1)->radio('testRadio');
echo $form->addText('Radio 1');
echo $form->addAttr('value',2)->radio('testRadio');
echo $form->addText('Radio 2');
````

Checkbox field
````php
echo $form->addAttr('value',1)->checkbox('testCheckbox[]');
echo $form->addText('Checkbox 1');
echo $form->addAttr('value',2)->checkbox('testCheckbox[]');
echo $form->addText('Checkbox 2');
````

## Add submit button
````php
// Accept one arg (value)
echo $form->addClass('btn btn-success')->submit('Send my Form');
````

#License
(MIT License)

Copyright (c) 2012-2015 Hakim Chmimo ab.chmimo@gmail.com

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.