<?php
namespace app\controllers;

use app\models\Nptquestions;

class PersonalityController extends \lithium\action\Controller {

	protected function _init() {
  parent::_init();
//  $user = Session::read('default');
  // if($user==null){
   // return $this->redirect('/savings');
  // }
  $this->_render['layout'] = 'default';
 }


public function npt(){
	
	$questions = nptquestions::find('all',array(
		'order'=>array('Question'=>'ASC')
	));
	$allquestions = array();
	foreach($questions as $q){
		array_push($allquestions,
			array(
				'Question'=>$q['Question'],
				'QA'=>$q['QA'],
				'HA'=>$q['HA'],
				'AA'=>$q['AA'],
				'QB'=>$q['QB'],
				'HB'=>$q['HB'],
				'AB'=>$q['AB'],
			)
		);
	}
	return $allquestions;
}


public function persons(){
	$persons = nptpersons::find('all',array(
		'order'=>array('Name'=>'ASC')
	));
	$allpersons = array();
	foreach($persons as $p){
		array_push($allpersons,
			array(
				'Name'=>$p['Name'],
				'Type'=>$p['Type'],
			)
		);
	}
	return $allpersons;
}

public function register(){
	if($this->request->data){
		$user = nptusers::create()->save($this->request->data);
		return true;
	}
	return true;
}





}
?>

