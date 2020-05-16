<?php
namespace app\controllers;

use app\extensions\action\Functions;
use Google_Service_Sheets;
use app\extensions\action\Google;
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
	public function product(){
		
		
	}
	public function discovery(){
		
		
	}
	
	public function join(){
		
		
	}
	
	public function zoom(){
		
		if($this->request->data){
			
			
		}
		$meetings = Meetings::find('all');
		$users = Users::find('all');
		return compact('meetings','users');
	}


function getData($spreadsheetId = null, $range=null){
	$google = new Google();
	
	$client = $google->getClient();
	$service = new Google_Service_Sheets($client);

// Prints the names and majors of students in a sample spreadsheet:
//		https://docs.google.com/spreadsheets/d/1odUoJH65EehXvTGlYPAWVEzbpbzvlWMQUv7F0EMdsJU/edit#gid=803667879
// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
$spreadsheetId = $spreadsheetId;//'1k_drULVRNXzKxFJdgSr5D43vlI0CzISB9Gru8dGYUQI';
$range = str_replace("_"," ",$range); //'Form responses 1!A1:J';
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
									'name'=>$row[0],
									'mobile'=>$row[1],
									'boxes'=>$row[2],
									'time'=>$row[3],
									'email'=>$row[4],
									'date'=>$row[5],
									'occupation'=>$row[6],
									'address'=>$row[7],
									'commit'=>$row[8],
									'signature'=>$row[9]?:"",
									)
									);
    }
}

return compact('names');
	
}

public function sendsms (){
	if ($this->request->data){
		$function = new Functions();
		$mobiles = $this->request->data['mobiles'];
		$message = str_replace("<div>","",$this->request->data['message']);
		$message = str_replace("</div>","",$message);
		$message = str_replace("<br>","\n",$message);

		$users = split(",",$mobiles);
		
		foreach($users as $u){
			$mobile = split('#',$u);
//			$returncall = $function->twilio('+91'.$mobile[0],"Testing",'45678988');	 // Testing if it works 
			$returnsms = $function->sendSms('+91'.$mobile[0],$message);	 // Testing if it works 	
		}
		$data = array(
			'u'=>$users,
			'm'=>$message
			);
	}
		return $this->render(array('json' => array("success"=>"Yes",'data'=>$data)));		
}

}
?>