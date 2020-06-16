<?php
use app\models\English;
use kartik\file\FileInput;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'CSV Spliter';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?=$this->title?></h1>

<!--        --><?//= GridView::widget([
//            'dataProvider' => $dataProvider,
//            //                         'filterModel' => $event['searchModel'],
//            'tableOptions' => ['class' => 'table table-striped table-bordered'],
//            'emptyCell'=>'',
//            'columns' => [
//                ['attribute' => 'productid', 'format' => 'raw', 'contentOptions' => ['style' => 'width:200px; white-space: normal;'],],
//                ['attribute' => 'Related_KB_Name', 'format' => 'raw'],
//                ['attribute' => 'Related_KB_ID', 'format' => 'raw'],
//                ['attribute' => 'new_labels', 'format' => 'raw'],
//            ],
//        ]);
        ?>

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
//            ['class' => 'kartik\grid\SerialColumn'],
//
//                [
//                    'attribute' => 'context',
//                    'format'    => 'raw',
//                    'value'     => function ($model) {
//                        if ($model->context != null) {
//                            return $model->context;
//                        } else {
//                            return '';
//                        }
//                    },
//                ],
                ['attribute' => 'productid', 'format' => 'raw', 'contentOptions' => ['style' => '    overflow: auto;
    white-space: normal;
    display: block;
    width: 200px; min-height: 150px;'],],
                ['attribute' => 'Related_KB_Name', 'format' => 'raw'],
                ['attribute' => 'Related_KB_ID', 'format' => 'raw'],
                ['attribute' => 'new_labels', 'format' => 'raw'],

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

    </div>

</div>
