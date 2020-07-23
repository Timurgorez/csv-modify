<?php
use app\models\English;
use app\models\EnglishKb;
use app\models\EnglishNanorep;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'JSON Filter';
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

        <?= $form->field($model, 'json_data')->textarea() ?>




        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>


    </div>

</div>
<script>

    
    
</script>