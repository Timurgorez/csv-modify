<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EnglishNanorepSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'English Nanoreps');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="english-nanorep-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create English Nanorep'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Add Related Articles'), ['/site/join-tables'], ['class' => 'btn btn-warning']) ?>

        <?= Html::a(Yii::t('app', 'Add full path to Images'), ['add-path-img'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Change Phrasings'), ['change-phrasings'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Clear This Table'), ['trancate-table'], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to clear table?'),
                ]
            ]) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'id' => 'grid',
        'toolbar' => [
            ['content'=>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['ctrl-action'], ['data-pjax'=>false, 'class' => 'btn btn-default', 'title'=>'Reset Grid'])
            ],
            '{export}',
            '{toggleData}'
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-cloud"></i> Output Daily Data </h3>',
            'type'=>'primary',
            'before'=>Html::a(''),
            'after'=>Html::a(''),
            'showFooter'=>false
        ],
        'columns' => [
//            ['class' => 'kartik\grid\SerialColumn'],
//
//            'id',
            'internalId',
            'question',
//            'plain_text_answer:ntext',
            'html_answer:ntext',
            'labels',
            [
                'attribute' => 'context',
                'format'    => 'raw',
                'value'     => function ($model) {
                    if ($model->context != null) {
                        return $model->context;
                    } else {
                        return '';
                    }
                },
            ],
            'phrasings',
//            'external_id',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
        'responsive'=>true,
        'hover'=>true,
        'exportConfig' => [
            GridView::CSV => ['label' => 'Export as CSV', 'filename' => 'File_Name-'.date('d-M-Y')],
            GridView::HTML => ['label' => 'Export as HTML', 'filename' => 'File_Name -'.date('d-M-Y')],
            GridView::PDF => ['label' => 'Export as PDF', 'filename' => 'File_Name -'.date('d-M-Y')],
            GridView::EXCEL=> ['label' => 'Export as EXCEL', 'filename' => 'File_Name -'.date('d-M-Y')],
            GridView::TEXT=> ['label' => 'Export as TEXT', 'filename' => 'File_Name -'.date('d-M-Y')],
        ],
        'export' => [
            'fontAwesome' => true
        ],
   ]); ?>




    <?php Pjax::end(); ?>

</div>
