<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Tag;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tag Table';
$this->params['breadcrumbs'][] = $this->title;

function tag_is_in_array($tag, $parentTags)
{
	if (is_array($parentTags) == false)
	{
		echo "(no array)";
		return false;
	}
	
	foreach($parentTags as $parentTag)
	{
		//echo "(".$parentTag->tag_id."==".$tag->tag_id.")";
		if ($parentTag->tag_id == $tag->tag_id)
		{
			return true;
		}
	}
	
	return false;
}

?>
<div class="tag-table">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tag', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	
	<?php
	
	$all = Tag::find()->all();
	
	$wichtigkeitModel = Tag::findOne(1);
	$dringlichkeitModel = Tag::findOne(4);
	
	$xAxisModel = $wichtigkeitModel;
	$yAxisModel = $dringlichkeitModel;
	
	$xAxisChildModels = $xAxisModel->getChildTags()->all();
	$yAxisChildModels = $yAxisModel->getChildTags()->all();
	
	?>
	<table class="table table-striped table-bordered">
		<thead>	
			<tr>
			<td></td>
			<?php
			foreach ($xAxisChildModels as $xAxisChildModel)
			{
				?>
				<td>
					<?= $xAxisChildModel->title; ?>
				</td>
				<?php 
			}
			?>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($yAxisChildModels as $yAxisChildModel)
			{
				?>
				<tr>
					<td>
						<?= $yAxisChildModel->title; ?>
					</td>
					
					<?php
					foreach ($xAxisChildModels as $xAxisChildModel)
					{
						?>
						<td>
						
							
							<?php
							foreach ($all as $tag)
							{
								//echo $xAxisChildModel->title." ".$yAxisChildModel->title;
								//echo $tag->tag_id.":".$tag->getParentTags()->one()."<br>";
								//var_dump($tag->getChildTags());
								
								if (tag_is_in_array($xAxisChildModel, $tag->getParentTags()->all()) 
									&& tag_is_in_array($yAxisChildModel, $tag->getParentTags()->all()))
								{
									//echo "treffer";
									//echo $tag->title;
									echo "<span class=\"label label-default\">".$tag->title."</span><br>";
								}
							}
							?>
							
							
						</td>
						<?php 
					}
					?>
					
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tag_id',
            'title:ntext',
            'description:ntext',
			//'editableParentTags:Array',
			//'parentTags:VarExport',
			[
				'attribute' => 'parentTags',
				'value' => function ($data) {
					
					$titles = array();
					
					foreach ($data->getParentTags()->all() as $parentTag)
					{
						$titles[] = $parentTag->title;
					}
					
					return implode(', ', $titles);
					
				},
				//'label' => 'Name',
			],
			[
				'attribute' => 'childTags',
				'value' => function ($data) {
					
					$titles = array();
					
					foreach ($data->getChildTags()->all() as $childTag)
					{
						$titles[] = $childTag->title;
					}
					
					return implode(', ', $titles);
					
				},
				//'label' => 'Name',
			],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
