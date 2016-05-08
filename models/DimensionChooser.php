<?php

namespace app\models;

use Yii;
use yii\base\Model;

class DimensionChooser extends Model
{
    public $xAxisModelID;
    public $yAxisModelID;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['xAxisModelID', 'yAxisModelID'], 'required'],
        ];
    }
}
