<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'meican',
    'name'=>'MEICAN',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'debug','session'],
    'defaultRoute' => 'home',
    'modules' => [
	    'debug' => [
	    	'class' => 'yii\debug\Module',
	    	//'allowedIPs' => ['143.54.12.245']
	    ],
        'aaa' => 'meican\aaa\Module',
        'base' => 'meican\base\Module',
        'circuits' => 'meican\circuits\Module',
        'home' => 'meican\home\Module',
        'scheduler' => 'meican\scheduler\Module',
        'topology' => 'meican\topology\Module',
        'bpm' => 'meican\bpm\Module',
        'notification' => 'meican\notification\Module',
        'gii' => 'yii\gii\Module',
	],
    'aliases' => [
        '@meican' => '@app/modules',
    ],
    'components' => [
        'assetManager' => [
            'linkAssets' => true,
            'appendTimestamp' => true,
            'bundles' => [ 
                'yii\jui\JuiAsset' => [
                    'css' => [],
                    'js' => [],
                    'depends' => [
                        'meican\base\assets\MeicanJuiAsset',
                    ]
                ]
            ],
        ],
    	'urlManager' => [
	    	'class' => 'yii\web\UrlManager',
	    	'enablePrettyUrl' => true,
	    	'showScriptName' => false,
    	],
    	'session' => [
	    	'class' => 'yii\web\Session',
	    	//'cookieParams' => ['httpOnly' => true, 'lifetime'=> 3600],
	    	//'timeout' => 3600,
	    	//'useCookies' => true,
    	],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'meican\aaa\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['aaa/login']
        ],
        'errorHandler' => [
            'errorAction' => 'home/default/error',
        ],
        'mailer' => require(__DIR__ . '/mailer.php'),
        'log' => [
            'traceLevel' => YII_DEBUG ? 1 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'trace'],
                    'logFile' => dirname(__DIR__).'/runtime/logs/web.log',
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'authManager' => [
	        'class' => 'yii\rbac\DbManager',
	        'defaultRoles' => ['guest'],
        ],
        'i18n' => [
        	'translations' => [
	        	'aaa*' => [
		        	'class' => 'yii\i18n\PhpMessageSource',
		        	'basePath' => '@meican/aaa/messages',
			        'fileMap' => [
				        'aaa' => 'aaa.php',
			        ],
				],
		        'home*' => [
			        'class' => 'yii\i18n\PhpMessageSource',
			        'basePath' => '@meican/home/messages',
			        'fileMap' => [
				        'home' => 'home.php',
			        ],
		        ],
		        'bpm*' => [
			        'class' => 'yii\i18n\PhpMessageSource',
			        'basePath' => '@meican/bpm/messages',
			        'fileMap' => [
			        	'bpm' => 'bpm.php',
		        	],
		        ],
		        'circuits*' => [
			        'class' => 'yii\i18n\PhpMessageSource',
			        'basePath' => '@meican/circuits/messages',
			        'fileMap' => [
			        	'circuits' => 'circuits.php',
			        ],
		        ],
		        'topology*' => [
			        'class' => 'yii\i18n\PhpMessageSource',
			        'basePath' => '@meican/topology/messages',
			        'fileMap' => [
			        	'topology' => 'topology.php',
			        ],
		        ],
        		'notification*' => [
        			'class' => 'yii\i18n\PhpMessageSource',
        			'basePath' => '@meican/notification/messages',
        			'fileMap' => [
        				'notification' => 'notification.php',
        			],
        		],
	        ],
        ],
    ],
    'params' => $params,
];

return $config;
