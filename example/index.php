<?php
/**
 * Simple example to how use the class
 * updated at 17/10/2017 17:00:00
 */

require dirname(__DIR__) . '/vendor/autoload.php';
$form = \HakimCh\Form\Form::init();
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Form test</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="wrapper">
            <div class="debugger right">
                <h1>Submitted datas</h1>
                <div class="code">
                    <pre>POST : <?php dump($_POST); ?></pre>
                    <pre>GET : <?php dump($_GET); ?></pre>
                    <pre>Files : <?php dump($_FILES); ?></pre>
                </div>
            </div>
            <div class="container">
                <h1>Form class</h1>
                <?php
                echo $form->addAttr([
                            'id'=>'HakimCh',
                            'enctype'=>'multipart/form-data'
                        ])
                        ->open();
                ?>
                <div class="form-group">
                    <?php
                    echo $form->label('Name', 'user_name');
                    echo $form->addAttr('id', 'userName')
                            ->addAttr('placeholder', 'Your name')
                            ->text('user_name');
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $form->label('Age', 'user_age');
                    echo $form->addAttr('id', 'userAge')
                            ->addAttr('placeholder', 'Your age')
                            ->text('user_age');
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $form->label('Email address', 'user_email');
                    echo $form->addAttr('id', 'userEmail')
                            ->addAttr('placeholder', 'Your email address')
                            ->text('user_email');
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $form->label('Image', 'user_photo');
                    echo $form->addAttr('id', 'userImage')
                            ->file('user_photo');
                    ?>
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <label>
                    <?php
                    echo $form->addAttr('value','F')
                            ->radio('user_gender', 'Female');
                    ?>
                    </label>
                    <label>
                    <?php
                    echo $form->addAttr('value','M')
                            ->radio('user_gender', 'Male');
                    ?>
                    </label>
                </div>
                <div class="form-group">
                    <label>Skills</label>
                    <label>
                    <?php
                    echo $form->addAttr('value','css')
                            ->checkbox('user_skills[]', 'CSS');
                    ?>
                    </label>
                    <label>
                    <?php
                    echo $form->addAttr('value','php')
                        ->checkbox('user_skills[]', 'PHP');
                    ?>
                    </label>
                    <label>
                    <?php
                    echo $form->addAttr('value','mysql')
                        ->checkbox('user_skills[]', 'MySQL');
                    ?>
                    </label>
                </div>
                <div class="form-group">
                    <?php
                    echo $form->label('Bio', 'user_bio');
                    echo $form->addAttr('id', 'userBio')
                        ->addAttr('rows', 10)
                        ->textarea('user_bio');
                    ?>
                </div>
                <?php
                echo $form->submit('Submit');
                echo $form->close();
                ?>
            </div>
        </div>
    </body>
</html>
