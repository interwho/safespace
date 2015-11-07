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
define('TWITTER_OAUTH_CALLBACK', 'http://8c40bed8.ngrok.io/twitter');
//define('TWITTER_OAUTH_CALLBACK', 'http://www.thesafespace.com/twitter');