<?php

namespace app\controllers;

use yii;
use yii\web\Controller;
use yii\helpers\Url;

class SiteController extends Controller {



	public function actions()
	{

        return [
	        'docs' => [
	            'class' => 'genxoft\swagger\ViewAction',
	            'apiJsonUrl' => Url::to(['/site/json-schema'], true),
	        ],
	        'json-schema' => [
	            'class' => 'genxoft\swagger\JsonAction',
	            'dirs' => [
	                Yii::getAlias('@app/api/modules/v1/controllers'),
	                Yii::getAlias('@app/api/modules/v1/models'),
	            ],
	        ],
	        'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
		];
	}
	
	
    public function actionIndex(){
        return 'Hello Tavex';
    }
}