<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Libro $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="libro-form">

    <!-- Agregamos el parametro para que el formulari permita subir archivos -->
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= Html::img( $model->imagen, ['width' => '60px'] ) ?>

    <?= $form->field($model, 'archivo')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
