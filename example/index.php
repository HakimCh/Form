<?php
// Include Form class
include '../Form.php';
// Initialize the Form object
$form = new HakimCh\Form\Form();
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Form test</title>
        <style>
			.code{padding:20px;background:#eee;color:#333;font-size:12px;line-height:18px;text-align:left;}
			input[type='text'],select,textarea{width:100%;border:1px #ccc solid;padding:8px;}
			.container{width:400px;background:#fff;padding:30px;margin:0 auto;}
        	body{background:whitesmoke;font-family:Arial;font-size:14px;}
			input[type='radio'],input[type='checkbox']{width:auto;}
			.code p{margin:0 0 20px 0;color:#000;font-size:14px;}
			h1{margin: 0 0 30px 0;text-align:center;}
			label{display:block;font-size:12px;margin-bottom:5px;}
			.form-group{margin-bottom:20px;}
			form{margin-top:30px;}
        </style>
    </head>
    <body>
    	<div class="container">
    		<h1>Form class</h1>
    		<div class="code">
    		<p><strong>Fields array</strong></p>
    		<?php var_dump($form->datas); ?>
    		</div>
    		<div class="code">
    		<p><strong>Files array</strong></p>
    		<?php var_dump($form->files); ?>
    		</div>
    		<?php
    		$form->addAttr('id', 'HakimCh')
				->usedFor('upload')
				->open();
			?>
    		<div class="form-group">
    			<?php
    			$form->label('Name', 'user_name');
    			$form->addAttr('id', 'userName')->addAttr('placeholder', 'Your name')->text('user_name');
    			?>
			</div>
    		<div class="form-group">
    			<?php
    			$form->label('Age', 'user_age');
    			$form->addAttr('id', 'userAge')->addAttr('placeholder', 'Your age')->text('user_age');
    			?>
			</div>
    		<div class="form-group">
    			<?php
    			$form->label('Email address', 'user_email');
    			$form->addAttr('id', 'userEmail')->addAttr('placeholder', 'Your email address')->text('user_email');
    			?>
			</div>
			<div class="form-group">
    			<?php
    			$form->label('Image', 'user_photo');
    			$form->addAttr('id', 'userImage')->file('user_photo');
    			?>
			</div>
			<div class="form-group">
				<label>Gender</label>
				<label>
				<?php
				$form->addAttr('value','F')->radio('user_gender');
				$form->addText('Female');
				?>
				</label>
				<label>
				<?php
				$form->addAttr('value','M')->radio('user_gender');
				$form->addText('Male');
    			?>
				</label>
			</div>
			<div class="form-group">
				<label>Skills</label>
				<label>
				<?php
				$form->addAttr('value','css')->checkbox('user_skills[]');
				$form->addText('CSS');
				?>
				</label>
				<label>
				<?php
				$form->addAttr('value','php')->checkbox('user_skills[]');
				$form->addText('PHP');
				?>
				</label>
				<label>
				<?php
				$form->addAttr('value','mysql')->checkbox('user_skills[]');
				$form->addText('MySQL');
    			?>
				</label>
			</div>
			<div class="form-group">
    			<?php
    			$form->label('Bio', 'user_bio');
    			$form->addAttr('id', 'userBio')->addAttr('rows', 10)->textarea('user_bio');
    			?>
			</div>
			<?php
			$form->submit('Submit');
			$form->close();
			?>
    	</div>
    </body>
</html>