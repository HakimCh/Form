<?php
include 'Form.php';

use HakimCh\Form\Form;

Form::init()->setup($_POST, 'dqzdsqd', 'index.php');

$form = Form::init();

echo $form->open($_POST);

	echo $form->label('Label 1');
	echo $form->text('Label 1');

echo $form->close();