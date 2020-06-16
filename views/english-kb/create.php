<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EnglishKb */

$this->title = Yii::t('app', 'Create English Kb');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'English Kbs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="english-kb-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
