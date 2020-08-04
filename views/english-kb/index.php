<?php

use yii\helpers\Html;
use kartik\grid\GridView;
//use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EnglishKbSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'English Kbs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="english-kb-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create English Kb'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Find Duplicate Articles'), ['find-duplicate-articles'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Clear This Table'), ['trancate-table'], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to clear table?'),
            ]
        ]) ?>
        <?= Html::a(Yii::t('app', 'Add full path to Images'), ['add-path-img'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Modify Phrasings'), ['modify-phrasings'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Check Id'), ['check-id'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a(Yii::t('app', 'Remove Tags From Title'), ['remove-tags-from-title'], ['class' => 'btn btn-warning']) ?>
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
//            ['class' => 'yii\grid\SerialColumn'],

            'article_id',
            'title',
            'answer:ntext',
            [
                'attribute' => 'label',
                'format'    => 'ntext',
                'value'     => function ($model) {
                    if ($model->label != null) {
                        return $model->label;
                    } else {
                        return '';
                    }
                },
            ],
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
            [
                'attribute' => 'phrasings',
                'format'    => 'raw',
                'value'     => function ($model) {
                    if ($model->phrasings != null) {
                        return $model->phrasings;
                    } else {
                        return '';
                    }
                },
            ],
            [
                'attribute' => 'notes',
                'format'    => 'raw',
                'label'     => 'notes',
                'value'     => function ($model) {
                    if ($model->notes != null) {
                        return $model->notes;
                    } else {
                        return '';
                    }
                },
            ],
//            'related_article',

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
