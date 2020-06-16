<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EnglishNanorep */

$this->title = Yii::t('app', 'Create English Nanorep');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'English Nanoreps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="english-nanorep-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
