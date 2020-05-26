<?php
namespace app\controllers;
use app\models\Networks;

class NetworkController extends \lithium\action\Controller {

	 protected function _init() {
  parent::_init();

  $this->_render['layout'] = 'default';
 }
	public function index($month = null){
		
		$networks = Networks::find('all',array(
			'conditions'=>array('Month'=>array('$lte'=>(integer)$month))
		));
		return compact('networks');
		return $this->render(array('json' => array("success"=>"Yes",'networks'=>$networks)));		
	}
	
	
	
	public function addUser(){
		if($this->request->data){
			
				$data = array(
									'Name' => $this->request->data['userName'],
									'refer_id' => $this->request->data['referName'],
									'Month' => (integer)$this->request->data['monthJoin'],
									'DateTime' => new \MongoDate(),
        );
								
					$refer = Networks::first(array(
						'conditions'=>array('_id'=>(string)$data['refer_id'])
					));
				if(count($refer)>0){
						$refer_ancestors = $refer['ancestors'];
						$refer_ancestors_name = $refer['ancestors_names'];
							$ancestors = array();
							$ancestors_names = array();
							if(count($refer_ancestors)>0){
								foreach ($refer_ancestors as $ra){
									array_push($ancestors, $ra);
								}
							}
							if(count($refer_ancestors_name)>0){
								foreach ($refer_ancestors_name as $ra){
									array_push($ancestors_names, $ra);
								}
							}
					$refer_id = (string) $refer['_id'];
					$refer_name = (string) $refer['Name'];
					
					array_push($ancestors,$refer_id);
					array_push($ancestors_names,$refer_name);

					$refer_left = (integer)$refer['left'];
					$refer_left_inc = (integer)$refer['left'];

					Networks::update(
						array(
							'$inc' => array('right' => (integer)2)
						),
						array('right' => array('>'=>(integer)$refer_left_inc)),
						array('multi' => true)
					);
					Networks::update(
						array(
							'$inc' => array('left' => (integer)2)
						),
						array('left' => array('>'=>(integer)$refer_left_inc)),
						array('multi' => true)
					);

					$newData = array(
									'Name' => $data['Name'],
									'MCA' => sha1($data['Name']),
									'Refer' => $refer['MCA'],
									'Month' => (integer)$data['Month'],
									'left'=>(integer)($refer_left+1),
									'right'=>(integer)($refer_left+2),
									'ancestors'=> $ancestors,
									'ancestors_names'=> $ancestors_names,
					);

  // "MCA": "0000001",
  // "Name": "You",
  // "Refer": "000000",
  // "left": 0,
  // "right": 1,
  // "ancestors": [],
  // "ancestors_names": []
		
					Networks::create()->save($newData);
				}
		}

//		return $this->redirect('/network/');
		
		return $this->render(array('json' => array("success"=>"Yes",'data'=>$data)));		
	}
}