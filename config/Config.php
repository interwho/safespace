<?php
define('PATH', realpath(__DIR__ . '/..'));

// Set Timezone
date_default_timezone_set('America/Toronto');

// Database
$GLOBALS['DATABASE'] = array(
    'dbname'   => 'safespace',
    'driver'   => 'pdo_mysql',
    'host'     => 'localhost',
    'user'     => 'root',
    'password' => 'root',
);

define('HAVEN_API_KEY', '0b33b80f-771d-436c-9347-88d0312e5a44');
define('BASE_HAVEN_URL', 'https://api.havenondemand.com/1/api/sync/analyzesentiment/v1?apikey=' . HAVEN_API_KEY);

define('TWITTER_CONSUMER_KEY', 'Ll1tmLRY4QJSuDxHa9LXZQ');
define('TWITTER_CONSUMER_SECRET', 'SWNp5WdpX7076n7mIZLtOtUrtzFK4nVOkyeDnDBWA');
define('TWITTER_OAUTH_CALLBACK', 'http://ea91ebdd.ngrok.io/twitter');
define('ACCESS_TOKEN', '257578069-bjidEub80l9fxpi0u1jr4x4abKGB2t5COoMo068k');
define('ACCESS_TOKEN_SECRET', 'DFTK7NacHeo3JLCZEmdFsWctnc4taGzWIyXMHbdh4ZfRH');
//define('TWITTER_OAUTH_CALLBACK', 'http://www.thesafespace.com/twitter');