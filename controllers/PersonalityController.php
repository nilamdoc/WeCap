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







}
?>

