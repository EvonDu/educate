<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\course\CourseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'num') ?>

    <?= $form->field($model, 'type_id') ?>

    <?= $form->field($model, 'instructor_id') ?>

    <?= $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'abstract') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'requirements_prerequisites') ?>

    <?php // echo $form->field($model, 'requirements_textbooks') ?>

    <?php // echo $form->field($model, 'requirements_software') ?>

    <?php // echo $form->field($model, 'requirements_hardware') ?>

    <?php // echo $form->field($model, 'next_term_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-search'></i> 搜索",["type" => "info", "submit" => true]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

