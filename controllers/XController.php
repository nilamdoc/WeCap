<?php
namespace app\controllers;

use Google_Client;
use Google_Service_Sheets;
use app\models\Meetings;
use app\models\Users;

class XController extends \lithium\action\Controller {

	 protected function _init() {
  parent::_init();
//  $user = Session::read('default');
  // if($user==null){
   // return $this->redirect('/savings');
  // }
  $this->_render['layout'] = 'default';
 }
	public function index(){
		return $this->render(array('json' => array("success"=>"Yes")));		
	}
	public function p(){
		
		
	}
	
	
	public function zoom(){
		
		if($this->request->data){
			
			
		}
		$meetings = Meetings::find('all');
		$users = Users::find('all');
		return compact('meetings','users');
	}


function getData(){
	$client = $this->getClient();
	$service = new Google_Service_Sheets($client);

// Prints the names and majors of students in a sample spreadsheet:
//		https://docs.google.com/spreadsheets/d/1odUoJH65EehXvTGlYPAWVEzbpbzvlWMQUv7F0EMdsJU/edit#gid=803667879
// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
$spreadsheetId = '1k_drULVRNXzKxFJdgSr5D43vlI0CzISB9Gru8dGYUQI';
$range = 'Form responses 1!A1:J';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();
$names = array();
if (empty($values)) {
  //  print "No data found.\n";
} else {
//    print "Name, Phone Number:\n";
    foreach ($values as $row) {
        // Print columns A and E, which correspond to indices 0 and 4.
       //printf("%s, %s,%s,%s,%s,%s, %s\n\n", $row[0],$row[1],$row[2],$row[3],'+91'.$row[4],$row[5], '+91'.$row[6]);
								array_push($names, array(
									'time'=>$row[0],
									'email'=>$row[1],
									'boxes'=>$row[2],
									'name'=>$row[3],
									'mobile'=>$row[4],
									'date'=>$row[5],
									'occupation'=>$row[6],
									'address'=>$row[7],
									'commit'=>$row[8],
									'signature'=>$row[9],
									)
									);
    }
}

return compact('names');
	
}


function getClient()
{
	
	
    $client = new Google_Client();
    $client->setApplicationName('Google Sheets API PHP Quickstart');
    $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}

public function g(){
// Get the API client and construct the service object.
$client = $this->getClient();
print_r($client);
$service = new Google_Service_Sheets($client);

// Prints the names and majors of students in a sample spreadsheet:
//		https://docs.google.com/spreadsheets/d/1odUoJH65EehXvTGlYPAWVEzbpbzvlWMQUv7F0EMdsJU/edit#gid=803667879
// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
//$spreadsheetId = '1odUoJH65EehXvTGlYPAWVEzbpbzvlWMQUv7F0EMdsJU';
$spreadsheetId = '1k_drULVRNXzKxFJdgSr5D43vlI0CzISB9Gru8dGYUQI';
$range = 'Form Responses 1!A2:J';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

if (empty($values)) {
    print "No data found.\n";
} else {
    print "Email Address, Name, Phone Number:\n";
    foreach ($values as $row) {
        // Print columns A and E, which correspond to indices 0 and 4.
        printf("%s, %s\n", $row[1], $row[3],'+91'.$row[4]);
    }
	}
}

















}
?>