<?php

namespace api\modules\v1;

use app\components\RestController;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;
use yii\web\Response;

abstract class Controller extends RestController
{
    public function behaviors()
    {
        return [
            'content' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'cors' => [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [
                        'X-Suggested-Filename',
                    ],
                ],
            ],
            'verb' => [
                'class' => VerbFilter::class,
                'actions' => $this->verbs(),
            ],
            'rate' => [
                'class' => RateLimiter::class,
            ],
        ];
    }

    public function message($data = [])
    {
	    $statusCode = \Yii::$app->response->getStatusCode();
	    
        return array_merge(['code'=> $statusCode, 'message' => Response::$httpStatuses[$statusCode]], 
        				   ['data' => $data]
						  );
    }
}
