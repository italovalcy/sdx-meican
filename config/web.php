<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'meican',
    'name'=>'MEICAN - Management Environment of Inter-domain Circuits for Advanced Networks',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['debug','session'],
    'defaultRoute' => 'init',
    'modules' => [
	    'debug' => [
	    	'class' => 'yii\debug\Module',
	    ],
	    'aaa' => 'app\modules\aaa\AaaModule',
		'circuits' => 'app\modules\circuits\CircuitsModule',
		'init' => 'app\modules\init\InitModule',
		'topology' => 'app\modules\topology\TopologyModule',
		'bpm' => 'app\modules\bpm\BpmModule',
    	'notification' => 'app\modules\notification\NotificationModule',
		'gii' => 'yii\gii\Module',
	],
    'components' => [
    	'urlManager' => [
	    	'class' => 'yii\web\UrlManager',
	    	'enablePrettyUrl' => true,
	    	'showScriptName' => false,
    	],
    	'session' => [
	    	'class' => 'yii\web\Session',
	    	'cookieParams' => ['httponly' => true, 'lifetime'=> 3600],
	    	'timeout' => 3600,
	    	'useCookies' => true,
    	],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['init/login']
        ],
        'errorHandler' => [
            'errorAction' => 'init/default/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
    		'transport' => [
    			'class' => 'Swift_SmtpTransport',
    			'host' => '',
    			'username' => '',
    			'password' => '',
    			'port' => '465',
    			'encryption' => 'ssl',
    		],
        ],
        'log' => [
            'flushInterval' => 200, 
            'traceLevel' => YII_DEBUG ? 1 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'trace'],
                    'exportInterval' => 200, 
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'authManager' => [
	        'class' => 'yii\rbac\DbManager',
	        'defaultRoles' => ['guest'],
        ],
        'formatter' => [
	        'timeZone' => 'America/Sao_Paulo',
	        'datetimeFormat' => 'dd/MM/yyyy HH:mm',
        ],
        'i18n' => [
        	'translations' => [
	        	'aaa*' => [
		        	'class' => 'yii\i18n\PhpMessageSource',
		        	'basePath' => '@app/messages',
			        'sourceLanguage' => 'en-US',
			        'fileMap' => [
				        'aaa' => 'aaa.php',
			        ],
				],
		        'init*' => [
			        'class' => 'yii\i18n\PhpMessageSource',
			        'basePath' => '@app/messages',
			        'sourceLanguage' => 'en-US',
			        'fileMap' => [
				        'init' => 'init.php',
			        ],
		        ],
		        'bpm*' => [
			        'class' => 'yii\i18n\PhpMessageSource',
			        'basePath' => '@app/messages',
			        'sourceLanguage' => 'en-US',
			        'fileMap' => [
			        	'bpm' => 'bpm.php',
		        	],
		        ],
		        'circuits*' => [
			        'class' => 'yii\i18n\PhpMessageSource',
			        'basePath' => '@app/messages',
			        'sourceLanguage' => 'en-US',
			        'fileMap' => [
			        	'circuits' => 'circuits.php',
			        ],
		        ],
		        'topology*' => [
			        'class' => 'yii\i18n\PhpMessageSource',
			        'basePath' => '@app/messages',
			        'sourceLanguage' => 'en-US',
			        'fileMap' => [
			        	'topology' => 'topology.php',
			        ],
		        ],
        		'notification*' => [
        			'class' => 'yii\i18n\PhpMessageSource',
        			'basePath' => '@app/messages',
        			'sourceLanguage' => 'en-US',
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
