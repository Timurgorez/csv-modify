<?php
use app\models\English;
use app\models\EnglishKb;
use app\models\EnglishNanorep;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'API Modify';
?>
<style>
    #customer-table, #nanorep-table{
        margin: 20px;
    }

</style>
<div class="site-index">

    <div class="jumbotron">
        <h1><?=$this->title?></h1>


        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'url')->textarea() ?>

        <?= $form->field($model, 'type_request')->textInput() ?>
        <?= $form->field($model, 'json_data')->textarea() ?>




        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>



        <?php if(Yii::$app->request->isPost) {
            echo GridView::widget([
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
        ]);  }?>


    </div>

</div>
<script>

    
    
</script>