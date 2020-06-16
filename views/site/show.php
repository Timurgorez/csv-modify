<?php
use app\models\English;
use kartik\file\FileInput;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'CSV Spliter';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?=$this->title?></h1>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //                         'filterModel' => $event['searchModel'],
            'tableOptions' => ['class' => 'table table-striped table-bordered'],
            'emptyCell'=>'',
            'columns' => [
                ['attribute' => 'article_id'],
                ['attribute' => 'title', 'format' => 'raw'],
                ['attribute' => 'answer', 'format' => 'raw'],
                ['attribute' => 'label'],
                ['attribute' => 'context'],
                ['attribute' => 'related_article'],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
        ?>

            <h1>NANO TABLE</h1>
        <?= GridView::widget([
            'dataProvider' => $dataProviderNano,
            //                         'filterModel' => $event['searchModel'],
            'tableOptions' => ['class' => 'table table-striped table-bordered'],
            'emptyCell'=>'',
            'columns' => [
                ['attribute' => 'article_id'],
                ['attribute' => 'title', 'format' => 'raw'],
                ['attribute' => 'answer', 'format' => 'raw'],
                ['attribute' => 'label'],
                ['attribute' => 'context'],
                ['attribute' => 'related_article'],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
        ?>

    </div>

</div>
