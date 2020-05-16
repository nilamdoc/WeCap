<?php
namespace app\controllers;

use app\extensions\action\Functions;
use Google_Service_Sheets;
use app\extensions\action\Google;
use app\models\Users;
use app\models\Steps;

use app\extensions\action\GoogleAuthenticator;

class SheetsController extends \lithium\action\Controller {

	protected function _init() {
  parent::_init();
//  $user = Session::read('default');
  // if($user==null){
   // return $this->redirect('/savings');
  // }
  $this->_render['layout'] = 'default';
 }

public function getSteps(){
	$steps = Steps::find('all',array(
		'order'=>array('_id'=>'ASC')
	));
	$alldata = array();
	foreach($steps as $s){
		$data = array();
		if($s['Responses']){
		$data = array(
			$s['Step'] => $this->getData($s['Responses'],$s['Step'].'!A1:AZ')
		);
		}
		if(count($data)>0){
		array_push($alldata,$data);
		}
	}
	return compact('steps','alldata');
}


public function getData($spreadsheetId = null, $range=null){
	
	$google = new Google();
	$client = $google->getClient();
	$service = new Google_Service_Sheets($client);
	
		$spreadsheetId = $spreadsheetId; //'1k_drULVRNXzKxFJdgSr5D43vlI0CzISB9Gru8dGYUQI';
		$range = str_replace("_"," ",$range);  //'Form responses 1!A1:J';
		$response = $service->spreadsheets_values->get($spreadsheetId, $range);
		$values = $response->getValues();
		$sheet = array();
		if (empty($values)) {
				//  print "No data found.\n";
		} else {
		//    print "Name, Phone Number:\n";
						foreach ($values as $row) {
										// Print columns A and E, which correspond to indices 0 and 4.
									//printf("%s, %s,%s,%s,%s,%s, %s\n\n", $row[0],$row[1],$row[2],$row[3],'+91'.$row[4],$row[5], '+91'.$row[6]);
										array_push($sheet, array(
											'TimeStamp'=>$row[0],
											'Email'=>$row[1],
											'Mobile'=>$row[2],
											'Name'=>$row[3],
											)
											);
						}
		}

return compact('sheet');
	
}

public function sendsms (){
	if ($this->request->data){
		$function = new Functions();
		$mobiles = $this->request->data['mobiles'];
		$message = "";
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


	public function sendotp(){
		if($this->request->data){
		
		$mobile = $this->request->data['mobile'];
			// if(substr($mobile,0,1)!="+"){
				// return $this->render(array('json' => array("success"=>"No")));		
			// }
	 
		$user = Users::find('first',array(
   'conditions'=>array(
				'mobile'=>(string)$mobile,
				)
		));
		
		if(count($user)==1){
			$mobile = $this->request->data['mobile'];
			
			$ga = new GoogleAuthenticator();
			$otp = $ga->getCode($ga->createSecret(64));	
			$data = array(
				'otp' => $otp,
				);
			$conditions = array("mobile"=>(string)$this->request->data['mobile']);
			
			Users::update($data,$conditions);
			$function = new Functions();
			$msg = "". $otp . " is the OTP for We Capacitate registration in the app";
			$returncall = $function->twilio("+91".$mobile,$msg,$otp);	 // Testing if it works 
			$returnsms = $function->sendSms("+91".$mobile,$msg);	 // Testing if it works 
			$user = Users::find('first',array(
   'conditions'=>$conditions
			));
				return $this->render(array('json' => array("success"=>"Yes","otp"=>$otp,'user'=>$user)));		
		}else{
				$conditions = array("mobile"=>(string)$this->request->data['mobile']);
				$ga = new GoogleAuthenticator();
				$otp = $ga->getCode($ga->createSecret(64));	
				
				$data = array(
					'mobile' => $this->request->data['mobile'],
					'otp' => $otp,
					'DateTime'=>new \MongoDate,
				);
				Users::create()->save($data);
				$function = new Functions();
				$msg = "". $otp . " is the OTP for We Capacitate registration in the app";
				$returncall = $function->twilio("+91".$mobile,$msg,$otp);	 // Testing if it works 
				$returnsms = $function->sendSms("+91".$mobile,$msg);	 // Testing if it works 
				$user = Users::find('first',array(
					'conditions'=>$conditions
					));
				return $this->render(array('json' => array("success"=>"Yes","otp"=>$otp,'user'=>$user)));		
				
		}
	}
	return $this->render(array('json' => array("success"=>"No")));		
	}














}
?>

