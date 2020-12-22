<?php

$db = require(__DIR__ . '/db.php');
$params = require(__DIR__ . '/params.php');	
$rules = require(__DIR__ . '/rules.php');

return [
    'id' => 'micro-app',
    'basePath' => dirname(__DIR__),
    
	'modules' => [
        'v1' => [
	        'basePath' => '@app/api/modules/v1',
            'class' => 'api\modules\v1\Module',
        ],
    ],
    
    'aliases' => [
		'@bower' => '@vendor/bower-asset',
		'@npm'   => '@vendor/npm-asset',
	],
	
   	
    'components' => [
	    
	    'db' => $db,
	    
	    'request' => [
            'cookieValidationKey' => 'JOfyckvqYTzdr6YQcluvhXWLxAcGpey',
            //Enable Json Input
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
		
		'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

		'formatter' => [
			'class' => 'yii\i18n\Formatter',
			'dateFormat' => 'php:d-M-Y',
			'datetimeFormat' => 'php:d-M-Y H:i:s',
			'timeFormat' => 'php:H:i:s',
			'defaultTimeZone' => 'Europe/Tallinn', 
		],
		
	    'user' => [
            'identityClass' => 'micro\models\User',
            'enableAutoLogin' => false,
        ],
        
	    'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
				'' => 'site/index',
				'docs' => 'site/docs',
				'/site/json-schema' => 'site/json-schema',
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => ['v1'],
                    'extraPatterns' => $rules,
                ],
            ],
        ],
 
	],
	
	'params' => $params,
];

