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
								if (tag_is_in_array($xAxisChildModel, $tag->getParentTags()->all()) 
									&& tag_is_in_array($yAxisChildModel, $tag->getParentTags()->all()))
								{
									?>
									<?= Html::a($tag->title, ['update', 'id' => $tag->tag_id], ['class' => 'btn btn-default']) ?>
									
									<?php
									foreach ($tag->getParentTags()->all() as $subtag)
									{
										if ($subtag->tag_id == $xAxisChildModel->tag_id || $subtag->tag_id == $yAxisChildModel->tag_id)
										{
											continue;
										}
										?>
										<span class="label label-default"><?=$subtag->title?></span>
										<?php
									}
									?>
									
									<br />
									<?php
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
	
</div>
