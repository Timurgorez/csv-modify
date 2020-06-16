<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EnglishKbSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="english-kb-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'article_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'answer') ?>

    <?= $form->field($model, 'label') ?>

    <?php // echo $form->field($model, 'context') ?>

    <?php // echo $form->field($model, 'related_article') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
