<?php

define('LITHIUM_APP_PATH', dirname(dirname(__DIR__)));

define('LITHIUM_LIBRARY_PATH', LITHIUM_APP_PATH . '/libraries');

// OAuth & site configuration
$oauthClientID     = '536942404241-enfsskrf69oh46o6bd0bqo8688l8nfv7.apps.googleusercontent.com';
$oauthClientSecret = '7HP5h4eyoyIrGWEf6fDk8REw';
$baseURL           = 'https://wecap/y/';
$redirectURL       = $baseURL.'upload';

define('OAUTH_CLIENT_ID',$oauthClientID);
define('OAUTH_CLIENT_SECRET',$oauthClientSecret);
define('REDIRECT_URL',$redirectURL);
define('BASE_URL',$baseURL);


// Include google client libraries
//require_once LITHIUM_LIBRARY_PATH .'/google-apiclient/src/Google/autoload.php'; 
require_once LITHIUM_LIBRARY_PATH .'/google/apiclient/src/Google/Client.php';
require_once LITHIUM_LIBRARY_PATH .'/google/apiclient-services/src/Google/Service/YouTube.php';

if(!session_id()) session_start();

$client = new Google_Client();
$client->setClientId(OAUTH_CLIENT_ID);
$client->setClientSecret(OAUTH_CLIENT_SECRET);
$client->setScopes('https://www.googleapis.com/auth/youtube');
$client->setRedirectUri(REDIRECT_URL);

print_r($client);
// Define an object that will be used to make all API requests.
$youtube = new Google_Service_YouTube($client);
    
?>