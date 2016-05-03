<?php

namespace app\controllers;

use Yii;
use app\models\Tag;
use app\models\TagSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TagController implements the CRUD actions for Tag model.
 */
class TagController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Tag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	/**
     * Lists all Tag models in a table.
     * @return mixed
     */
    public function actionTable()
    {
        $searchModel = new TagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('table', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tag model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tag();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tag_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tag_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tag::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function getAllTagsWithParentTags()
	{
		$allTags = Tag::find()->all();
		
		$xAxisModel = null;
		$yAxisModel = null;
		$xAxisChildModels = array();
		$yAxisChildModels = array();
		$xAxisModelID = 1;
		$yAxisModelID = 10;
		
		// find tags of the X/Y-Axis
		foreach ($allTags as $tag)
		{
			if ($tag->tag_id == $xAxisModelID)
			{
				$xAxisModel = $tag;
			}
			else if($tag->tag_id == $yAxisModelID)
			{
				$yAxisModel = $tag;
			}
			
			// break if both models are found
			if ($xAxisModel != null && $yAxisModel != null)
			{
				break;
			}
		}
		
		// set parent tags for each tag
		foreach ($allTags as $tag)
		{
			$tag->cachedParentTags = $tag->getParentTags()->all();
		}
		
		// find child tags of X/Y-Axis-tags
		foreach ($allTags as $tag)
		{
			foreach ($tag->cachedParentTags as $parentTag)
			{
				if ($parentTag->tag_id == $xAxisModel->tag_id)
				{
					$xAxisChildModels[] = $tag;
				}
				else if($parentTag->tag_id == $yAxisModel->tag_id)
				{
					$yAxisChildModels[] = $tag;
				}
			}
		}
		
		return array($allTags, $xAxisModel, $yAxisModel, $xAxisChildModels, $yAxisChildModels);
	}
}
