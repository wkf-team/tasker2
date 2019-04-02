<?php

namespace app\controllers;

use yii\web\Response;

class ApiCommentController extends \yii\rest\ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['basicAuth'] = [
            'class' => \yii\filters\auth\HttpBasicAuth::className(),
        ];
		$behaviors['ContentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ]
        ];
        return $behaviors;
    }
    
    public $modelClass = 'app\models\Comment';
}
