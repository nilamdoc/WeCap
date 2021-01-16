<?php
namespace app\controllers;
use lithium\storage\Session;
use \lithium\template\View;
use \lithium\data\Model;
use app\models\Malls;
use app\models\Mobiles;
use app\models\Users;
use app\models\Lists;
use app\extensions\action\Functions;
use app\extensions\action\GoogleAuthenticator;

class MastermindController extends \lithium\action\Controller {
 
 
 protected function _init() {
  parent::_init();
//  $user = Session::read('default');
  // if($user==null){
   // return $this->redirect('/savings');
  // }
  $this->_render['layout'] = 'mastermind';
 }
 public function index(){
   return compact('a');
 }
}

