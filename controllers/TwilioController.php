<?php
namespace app\controllers;

use app\extensions\action\Functions;

class TwilioController extends \lithium\action\Controller {

	 protected function _init() {
  parent::_init();
//  $user = Session::read('default');
  // if($user==null){
   // return $this->redirect('/savings');
  // }
  $this->_render['layout'] = 'default';
 }
	public function index($mobile = null,$message = null){
		if($mobile == ""){
			return $this->render(array('json' => array("success"=>"No")));		
		}
		if($message == ""){
			return $this->render(array('json' => array("success"=>"No")));		
		}
		
		$function = new Functions();
		$function->twilio_api($mobile,$message);

		return $this->render(array('json' => array("success"=>"Yes")));		
	}
	public function One(){
		
	}
}