<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EnglishNanorepSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="english-nanorep-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'internalId') ?>

    <?= $form->field($model, 'created_date') ?>

    <?= $form->field($model, 'question') ?>

    <?= $form->field($model, 'plain_text_answer') ?>

    <?php // echo $form->field($model, 'html_answer') ?>

    <?php // echo $form->field($model, 'labels') ?>

    <?php // echo $form->field($model, 'phrasings') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
