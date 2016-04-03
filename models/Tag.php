<?php

namespace app\models;

use Yii;
use arogachev\ManyToMany\behaviors\ManyToManyBehavior;
use arogachev\ManyToMany\validators\ManyToManyValidator;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tags".
 *
 * @property integer $tag_id
 * @property string $title
 * @property string $description
 */
class Tag extends \yii\db\ActiveRecord
{
	public $editableParentTags = [];
	//public $editableChildTags = [];
	
	public function behaviors()
    {
        return [
			[
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                        [
                            'editableAttribute' => 'editableParentTags',
                            'name' => 'parentTags',
                        ],
						/*[
                            'editableAttribute' => 'editableChildTags',
                            'name' => 'childTags',
                        ],*/
                ],
            ],
        ];
    }
	
	public function getParentTags()
	{
		return $this->hasMany(Tag::className(), ['tag_id' => 'parent_id'])
			->viaTable('tags_tags', ['tag_id' => 'tag_id']);
	}
	
	public function getChildTags()
	{
		return $this->hasMany(Tag::className(), ['tag_id' => 'tag_id'])
			->viaTable('tags_tags', ['parent_id' => 'tag_id']);
	}

	public static function getList()
	{
		$models = static::find()->all();

		return ArrayHelper::map($models, 'tag_id', 'title');
	}
	

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'description'], 'string'],
			
			['editableParentTags', ManyToManyValidator::className()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tag_id' => 'Tag ID',
            'title' => 'Title',
            'description' => 'Description',
        ];
    }

    /**
     * @inheritdoc
     * @return TagsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TagsQuery(get_called_class());
    }
}
