<?php

use yii\helpers\Html;
use kartik\grid\GridView;
//use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EnglishKbSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Dynamic Table');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="english-kb-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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


            [
                'attribute' => 'article_id',
                'label' => 'externalId',
            ],
            [
                'attribute' => 'title',
                'label' => 'title',
            ],
            [
                'attribute' => 'answer',
                'label' => 'answer',
                'format'    => 'ntext',
            ],
            [
                'attribute' => 'label',
                'label' => 'label',
                'format'    => 'ntext',
            ],
            [
                'attribute' => 'context',
                'label' => 'context:prodId',
                'format'    => 'raw',
            ],
            [
                'attribute' => 'phrasings',
                'label' => 'phrasing',
                'format'    => 'raw',
            ],

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
