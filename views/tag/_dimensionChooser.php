<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\DimensionChooser;
use app\controllers\TagController;

/* @var $this yii\web\View */
?>

<div class="dimension-chooser">

    <?php $form = ActiveForm::begin([
        'action' => ['table'],
        'method' => 'get',
    ]); ?>
	
	
	
	<?php 
	
	$model = new DimensionChooser();
	
	$dimensionTags = TagController::getDimensionTags($allTags);
	$items = ArrayHelper::map($dimensionTags, 'tag_id', 'title');
	
	
	echo $form->field($model, 'xAxisModelID')
        ->dropDownList(
            $items,           // Flat array ('id'=>'label')
            ['prompt'=>'']    // options
        );
		
	echo $form->field($model, 'yAxisModelID')
        ->dropDownList(
            $items,           // Flat array ('id'=>'label')
            ['prompt'=>'']    // options
        );
	
	?>
	
	
    <div class="form-group">
        <?= Html::submitButton('Set Dimensions', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
