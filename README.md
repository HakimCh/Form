# Form Class
A simple html form generator class
[![Code Climate](https://codeclimate.com/github/HakimCh/Form/badges/gpa.svg)](https://codeclimate.com/github/HakimCh/Form)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c95d4bcb-9bef-4292-8d3a-e64baffd8794/small.png)](https://insight.sensiolabs.com/projects/c95d4bcb-9bef-4292-8d3a-e64baffd8794)

# Install via composer
````code
composer require 'hakimch/form'
````

# Initialize the form
````php
$form = HakimCh\Form\Form::init();
$form->setup(
    $datas, // Submited datas
    $token, // If you want add csrf token (require CSRF class)
    $action // Current url for action attribute
);
echo $form->addAttr([
                'id' => 'Form', // Adding attr Id
                'class' => 'formClass', // adding a class
                'enctype' => 'multipart/form-data' // If you want use it for upload some files
           ])->open();

// you can add fields here

echo $form->close(); // Closing form
````
## Add text field
You can add many field type as (text,password,date,time,file,hidden,textarea)
````php
// Create label(name, for, required)
// Required arg will add <span class="required">*</span>
echo $form->addAttr('for', firstName')->label('firstName', true);
// A normal text field with a name
echo $form->text('firstName');

// Add an Advanced text field with options
echo $form->addAttr([
        'id' => 'secondName',
        'value' => 'Chmimo',
        'class' => 'required greenColor'
      ]) // add attrs by passing an array
      ->text('secondName');
// Add a textarea
echo $form->addAttr('rows',5) // add number of rows
      ->addAttr('class','redBorder') // adding a class name
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
echo $form->addAttr('value',1)->radio('testRadio', 'Radio 1');
echo $form->addAttr('value',2)->radio('testRadio', 'Radio 2');
````

Checkbox field
````php
echo $form->addAttr('value',1)->checkbox('testCheckbox[]', 'Checkbox 1');
echo $form->addAttr('value',2)->checkbox('testCheckbox[]', 'Checkbox 2');
````

## Add submit button
````php
// Accept one arg (value)
echo $form->addAttr('class', 'btn btn-success')->submit('Send my Form');
````

#License
(MIT License)

Copyright (c) 2012-2015 Hakim Chmimo ab.chmimo@gmail.com

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
