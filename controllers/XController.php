<?php
namespace app\controllers;

use app\models\Meetings;

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
		return compact('meetings');
	}
}