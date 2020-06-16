<?php
use app\models\English;
use app\models\EnglishKb;
use app\models\EnglishNanorep;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'CSV Modify';
?>
<style>
    #customer-table, #nanorep-table{
        margin: 20px;
    }

</style>
<div class="site-index">

    <div class="jumbotron">
        <h1><?=$this->title?></h1>




        <?php
        if(Yii::$app->request->isPost) { ?>


        <?php
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
        ]);

        }else{
        ?>

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'exFile')->fileInput() ?>

        <?= $form->field($model, 'spliter')->checkbox()->label(false) ?>

        <p>In which table do you want to upload your data?</p>
        <?=
        $form->field($model, 'column')
            ->radioList(
                [1 => 'Customer', 2 => 'Nanorep'],
                [
                    'item' => function($index, $label, $name, $checked, $value) {
                        $id = uniqid();
                        $return = '<p>';
                        $return .= '<input type="radio" id="'.$id.'" name="' . $name . '" value="' . $value . '" tabindex="3">';
                        $return .= '<label for="'.$id.'" class="modal-radio">' . ucwords($label) . '</label>';
                        $return .= '</p>';

                        return $return;
                    }
                ]
            )
            ->label(false);
        ?>



        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <?php }?>


    </div>

</div>
<script>

    console.log(<?=json_encode($arrData)?>);
    
    if(document.getElementById('customer-table')){
//        document.getElementById('customer-table').addEventListener('click', function (e) {
//
//
//            var arrString = JSON.stringify(<?//=json_encode($arrData)?>//);
//            var body = 'data='+arrString;
//            console.log(body);
//
//            var xhr = new XMLHttpRequest();
//            xhr.open('POST', 'site/write-customer', true);
//
////            xhr.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + boundary);
//
//            xhr.onreadystatechange = function() {
//                if (this.readyState != 4) return;
//
//                console.log( this.responseText );
//            }
//
//            xhr.send(body);
//        })
    }
    
    
</script>