<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EnglishNanorep */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="english-nanorep-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'internalId')->textInput() ?>

    <?= $form->field($model, 'question')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'plain_text_answer')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'html_answer')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'labels')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phrasings')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
